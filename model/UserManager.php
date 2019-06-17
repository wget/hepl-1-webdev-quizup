<?php
require_once(ROOT_CGI . "/model/Database.php");

class UserManager {

    function isConnected() {

        if (isset($_SESSION["connected"]) && $_SESSION["connected"] == true) {
            return true;
        }
        return false;
    }

    function checkCredentials($email, $password) {
        $db = Database::getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->prepare("select * from profile_user_session where email = :email and password = password(:pwd)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pwd', $password);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($stmt->fetch() === false) {
            return false;
        }
        return true;
    }

    function getLanguages() {
        $db = database::getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->prepare("select * from lang order by name");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    function isLanguageCodeValid($code) {
        $db = database::getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->prepare("select name from lang where code = :code");
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetch();
        if ($result === false) {
            return false;
        }
        return true;
    }

    function getCountries() {
        $db = database::getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->prepare("select * from country order by name");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    function getRegions() {
        $db = database::getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->prepare("select * from region order by name");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    function saveProfilePictureToTemp($username, $picture, $filename) {
        $fileName = $username . time() . $fileName;
        try {
            if (($fileDescriptor = fopen(ROOT_WEB . '/uploads/' . $fileName, 'w')) === false) {
                throw new Exception("Unable to open file descriptor");
            }
            if (fwrite($fileDescriptor, $picture) === false) {
                throw new Exception("Unable to write to filename");
            }
            if (fclose($fileDescriptor) === false) {
                throw new Exception("Unable to close image file descriptor");
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $type = finfo_file($finfo, $filename);
            if (!isset($type) || !in_array($type, array("image/png", "image/jpeg", "image/gif"))) {
                throw new Exception("Filename is not an image");
            }
        } catch (Exception $e) {
            // Avoid temporary file if an issue occurred.
            unlink($fileName);
            throw $e;
        }
        return $filename;
    }

    function insertNewUser(
        $username, $email, $password, $originCity, $languageCode, $country,
        $region, $profilePicture, $profilePictureFilename, $bio) {

        $db = database::getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->prepare("insert into profile(name, select * from region order by name");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();

    }
    
    function isUsernameValid($username) {
        // In order to avoid being interpretated as a range, the dash must be
        // double escaped.
        return preg_match('/^([A-Za-z0-9 _\\-.\']+)$/i', $username) > 0 ? true : false;
    }

    function isUsernameUnique($username) {
        $db = Database::getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->prepare("select name from profile where name = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($stmt->fetch() === false) {
            return true;
        }
        return false;
    }

    function isEmailUnique($email) {
        $db = Database::getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->prepare("select email from profile_user_session where email = lower(:email)");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($stmt->fetch() === false) {
            return true;
        }
        return false;
    }

    function isOriginCityValid($originCity) {
        return preg_match('/^([A-Za-z0-9 _-.\']+)$/i', $username) > 0 ? true : false;
    }

    function isBioValid($bio) {
        return preg_match('/^([A-Za-z0-9 _-.\']+)$/i', $username) > 0 ? true : false;
    }

    // function registerValidate() {
    //
    // }
    //
}
