<?php
namespace App\Core;

class AdService
{

    public static function verifyUserAd($username, $password)
    {
        // LDAP server details
        $ldapServer = config('ldap.connections.default.settings.hosts')[0];
        $ldapPort = config('ldap.connections.default.settings.port');
        $ldapBaseDn = config('ldap.connections.default.settings.base_dn');

        // LDAP connection
        $ldapConn = ldap_connect($ldapServer, $ldapPort);

        if ($ldapConn) {
            // Set LDAP options
            ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);

            // Bind to LDAP server with a read-only user
            $ldapBind = ldap_bind($ldapConn, config('ldap.connections.default.settings.username'), config('ldap.connections.default.settings.password'));

            if ($ldapBind) {
                // Search for the user
                $ldapFilter = "(uid=" . ldap_escape($username, "", LDAP_ESCAPE_FILTER) . ")";
                $ldapSearch = ldap_search($ldapConn, $ldapBaseDn, $ldapFilter);

                if ($ldapSearch) {
                    $entries = ldap_get_entries($ldapConn, $ldapSearch);

                    if ($entries['count'] === 1) {
                        // Attempt to bind as the user with the provided password
                        $userDn = $entries[0]['dn'];
                        $userBind = ldap_bind($ldapConn, $userDn, $password);

                        if ($userBind) {
                            // Authentication successful
                            return true;
                        }
                    }
                }
            }
        }

        // Authentication failed
        return false;
    }

}
