<?php

namespace Peto16\User;

use \Anax\Database\ActiveRecordModel;
use \Peto16\User\UserStorageInterface;

/**
 * Class to handle a user.
 */
class UserActiveRecordModel extends ActiveRecordModel implements UserStorageInterface
{

    /**
    * @var string $tableName name of the database table.
    */
    protected $tableName = "ramverk1_User";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */

    public $id;
    public $username;
    public $password;
    public $email;
    public $firstname;
    public $lastname;
    public $administrator;
    public $enabled;
    public $deleted;



    /**
     * Create user.
     *
     * @param  User        $user a user object.
     *
     * @return void
     */
    public function createUser(User $user)
    {
        $this->setUserData($user);
        $this->save();
    }



    /**
     * Update user.
     *
     * @param  User        $user User object.
     *
     * @return void
     */
    public function updateUser(User $user)
    {
        $this->find("id", $user->id);
        $this->setUserData($user);
        $this->save();
    }



    /**
     * Delete user.
     *
     * @param  integer        $id, integer for userid.
     *
     * @return void
     */
    public function deleteUser($id)
    {
        $user = $this->find("id", $id);
        $this->id = $user->id;
        date_default_timezone_set("Europe/Stockholm");
        $this->deleted = date("Y-m-d H:i:s");
        $this->save();
    }



    /**
     * Dynamicly set user properties to its value.
     *
     * @param User            $user user object
     */
    public function setUserData(User $user)
    {
        $userVarArray = get_object_vars($user);

        foreach ($userVarArray as $key => $value) {
            if ($value != null) {
                $this->{$key} = $value;
            }
        }
    }



    /**
     * Dynamicly get user by field.
     *
     * @param  string          $field Fieldname to search.
     *
     * @param  mixed           $data Data to search for in the field.
     *
     * @return User            Returns a user.
     */
    public function getUserByField($field, $data)
    {
        return $this->find($field, $data);
    }



    /**
     * Returns all users stored and that are not deleted.
     *
     * @return array           Array with all users.
     */
    public function findAllUsers()
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->where("deleted IS NULL")
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }
}
