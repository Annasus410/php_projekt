<?php
/**
 *
 * Change password helper.
 */
namespace App\Form\Model;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword()
     */
    protected $oldPassword;
    protected $password;
    public function getOldPassword()
    {
        return $this->oldPassword;
    }
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($newPassword) {
        $this->password = $newPassword;
    }
}