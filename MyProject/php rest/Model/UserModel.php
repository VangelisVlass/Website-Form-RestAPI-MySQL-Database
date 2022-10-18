<?php
header('Access-Control-Allow-Origin: *');
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class UserModel extends Database
{
    public function getUsers()
    {
        return $this->select("SELECT * FROM users");
    }
    public function getUserById()
    {
        return $this->select("SELECT * FROM users where id = ");
    }
    public function insertUser($inFirstName,  $inLastName, $inEmail, $inMobile, $inCategory)
    {
        return $this->edit("INSERT INTO users(
            firstname,
            lastname,
            email,
            mobile,
            category)
        VALUES 
           ('$inFirstName',
           '$inLastName',
           '$inEmail',
           '$inMobile',
           '$inCategory')");
    }

    public function updateUser($inId, $inFirstName,  $inLastName, $inEmail, $inMobile, $inCategory)
    {
        return $this->edit("UPDATE users
        SET firstname = '$inFirstName',
		lastname = '$inLastName',
        email = '$inEmail',
        mobile = '$inMobile',
        category = '$inCategory'
        WHERE id = $inId;");
    }

    public function deleteUser($inId)
    {
        return $this->edit("DELETE FROM users
        WHERE id = $inId");
    }
}
