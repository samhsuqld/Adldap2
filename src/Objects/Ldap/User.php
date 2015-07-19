<?php

namespace Adldap\Objects\Ldap;

use Adldap\Exceptions\AdldapException;
use Adldap\Objects\Traits\HasLastLogonAndLogOffTrait;
use Adldap\Objects\Traits\HasMemberOfTrait;

class User extends Entry
{
    use HasMemberOfTrait;

    use HasLastLogonAndLogOffTrait;

    /**
     * The required attributes for the toSchema methods.
     *
     * @var array
     */
    protected $required = [
        'username',
        'firstname',
        'surname',
        'email',
        'container',
    ];

    /**
     * Returns the users title.
     *
     * https://msdn.microsoft.com/en-us/library/ms680037(v=vs.85).aspx
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getAttribute('title', 0);
    }

    /**
     * Returns the users department.
     *
     * https://msdn.microsoft.com/en-us/library/ms675490(v=vs.85).aspx
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->getAttribute('department', 0);
    }

    /**
     * Returns the users first name.
     *
     * https://msdn.microsoft.com/en-us/library/ms675719(v=vs.85).aspx
     *
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->getAttribute('givenname', 0);
    }

    /**
     * Returns the users last name.
     *
     * https://msdn.microsoft.com/en-us/library/ms679872(v=vs.85).aspx
     *
     * @return mixed
     */
    public function getLastName()
    {
        return $this->getAttribute('sn', 0);
    }

    /**
     * Returns the users telephone number.
     *
     * https://msdn.microsoft.com/en-us/library/ms680027(v=vs.85).aspx
     *
     * @return string
     */
    public function getTelephoneNumber()
    {
        return $this->getAttribute('telephonenumber', 0);
    }

    /**
     * Returns the users company.
     *
     * https://msdn.microsoft.com/en-us/library/ms675457(v=vs.85).aspx
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->getAttribute('company', 0);
    }

    /**
     * Returns the users first email address.
     *
     * https://msdn.microsoft.com/en-us/library/ms676855(v=vs.85).aspx
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getAttribute('mail', 0);
    }

    /**
     * Returns the users email addresses.
     *
     * https://msdn.microsoft.com/en-us/library/ms676855(v=vs.85).aspx
     *
     * @return array
     */
    public function getEmails()
    {
        return $this->getAttribute('mail');
    }

    /**
     * Returns the users mailbox store DN.
     *
     * https://msdn.microsoft.com/en-us/library/aa487565(v=exchg.65).aspx
     *
     * @return string
     */
    public function getHomeMdb()
    {
        return $this->getAttribute('homemdb', 0);
    }

    /**
     * Returns the users mail nickname.
     *
     * @return string
     */
    public function getMailNickname()
    {
        return $this->getAttribute('mailnickname', 0);
    }

    /**
     * Returns the users principal name.
     *
     * This is usually their email address.
     *
     * https://msdn.microsoft.com/en-us/library/ms680857(v=vs.85).aspx
     *
     * @return string
     */
    public function getUserPrincipalName()
    {
        return $this->getAttribute('userprincipalname', 0);
    }

    /**
     * Returns the users proxy addresses.
     *
     * https://msdn.microsoft.com/en-us/library/ms679424(v=vs.85).aspx
     *
     * @return array
     */
    public function getProxyAddresses()
    {
        return $this->getAttribute('proxyaddresses');
    }

    /**
     * Returns the users script path if the user has one.
     *
     * https://msdn.microsoft.com/en-us/library/ms679656(v=vs.85).aspx
     *
     * @return string
     */
    public function getScriptPath()
    {
        return $this->getAttribute('scriptpath', 0);
    }

    /**
     * Returns the users bad password count.
     *
     * @return string
     */
    public function getBadPasswordCount()
    {
        return $this->getAttribute('badpwdcount', 0);
    }

    /**
     * Returns the users bad password time.
     *
     * @return string
     */
    public function getBadPasswordTime()
    {
        return $this->getAttribute('badpasswordtime', 0);
    }

    /**
     * Returns the users lockout time.
     *
     * @return string
     */
    public function getLockoutTime()
    {
        return $this->getAttribute('lockouttime', 0);
    }

    /**
     * Returns the users user account control integer.
     *
     * @return string
     */
    public function getUserAccountControl()
    {
        return $this->getAttribute('useraccountcontrol', 0);
    }

    /**
     * Returns the users profile file path.
     *
     * @return string
     */
    public function getProfilePath()
    {
        return $this->getAttribute('profilepath', 0);
    }

    /**
     * Returns the users legaxy exchange distinguished name.
     *
     * @return string
     */
    public function getLegacyExchangeDn()
    {
        return $this->getAttribute('legacyexchangedn', 0);
    }

    /**
     * Returns the users account expiry date.
     *
     * @return string
     */
    public function getAccountExpiry()
    {
        return $this->getAttribute('accountexpires', 0);
    }

    /**
     * Returns an array of address book DNs
     * that the user is listed to be shown in.
     *
     * @return array
     */
    public function getShowInAddressBook()
    {
        return $this->getAttribute('showinaddressbook');
    }

    /**
     * Checks the attributes for existence and returns the attributes array.
     *
     * @return array
     *
     * @throws AdldapException
     */
    public function toCreateSchema()
    {
        $this->validateRequired();

        if (!is_array($this->getAttribute('container'))) {
            throw new AdldapException('Container attribute must be an array');
        }

        // Set the display name if it's not set
        if ($this->getAttribute('display_name') === null) {
            $displayName = $this->getAttribute('firstname').' '.$this->getAttribute('surname');

            $this->setAttribute('display_name', $displayName);
        }

        return $this->getAttributes();
    }

    /**
     * Checks the username attribute for existence and returns the attributes array.
     *
     * @return array
     *
     * @throws AdldapException
     */
    public function toModifySchema()
    {
        $this->validateRequired(['username']);

        if ($this->hasAttribute('container')) {
            if (!is_array($this->getAttribute('container'))) {
                throw new AdldapException('Container attribute must be an array');
            }
        }

        return $this->getAttributes();
    }
}