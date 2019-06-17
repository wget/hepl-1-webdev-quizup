<?php

/**
 * This is our main controller and URL routing
 */

require_once("./config.php");
require_once(ROOT_CGI . "/model/UserManager.php");


function register() {

    $pageDescription = "Registration to QuizUp";
    $pageTitle = "QuizUp - Registrer";

    $userManager = new UserManager();
    $languages = $userManager->getLanguages();
    $countries = $userManager->getCountries();
    $regions = $userManager->getRegions();

    require(ROOT_CGI . "/view/registration.php");
}

function registerValidate() {

    // We are checking in the controller because we want more fine grained
    // error messages returned to the UI. If we were doing the check in the
    // model, we would have to catch a specific exception without being able to
    // know which exact field failed the validation.
    $all = array(
        "username", "email", "password", "originCity", "language", "country",
        "region", "profilePicture", "profilePictureFilename", "bio"
    );
    $required = array(
        "username", "email", "password", "language"
    );
    $jsonAnswer = array();
    $specified = array();
    $messages = array();

    // Get RAW JSON data
    $query = file_get_contents('php://input');
    $jsonQuery = json_decode($query, true);

    // Check for mandatory fields
    foreach ($required as $field) {
        if (empty($jsonQuery[$field])) {
            $messages[] = $field . "MissingRequired";
        }
    }

    // Return if there are missing mandatory fields
    if (!empty($missingRequired)) {
        header("Content-type: application/json");
        $jsonAnswer += array("success" => "false");
        $jsonAnswer += array("messages" => $messages);
        echo json_encode($jsonAnswer);
        return;
    }

    // Get specified fields since we can have optional ones
    foreach ($all as $field) {
        if (!empty($jsonQuery[$field])) {
            $specified[] = $field;
        }
    }

    $userManager = new UserManager();

    if (!$userManager->isUsernameValid($jsonQuery["username"])) {
        $messages[] = "usernameInvalid";
    }

    if (!$userManager->isUsernameUnique($jsonQuery["username"])) {
        $messages[] = "usernameNotUnique";
    }

    if (!filter_var($jsonQuery["email"], FILTER_VALIDATE_EMAIL)) {
        $messages[] = "emailInvalid";
    }

    if (!$userManager->isEmailUnique($jsonQuery["email"])) {
        $messages[] = "emailNotUnique";
    }

    if (!$userManager->isLanguageCodeValid($jsonQuery["language"])) {
        $messages[] = "languageInvalid";
    }

    // Check for optional parameters

    if (in_array($specified, "originCity") &&
        !$userManager->isOriginCityValid($jsonQuery["originCity"])) {
        $messages[] = "originCityInvalid";
    }

    if (in_array($specified, "bio") &&
        !$userManager->isBioValid($jsonQuery["bio"])) {
        $messages[] = "bioInvalid";
    }

    // Need filename if we have profile picture
    // A=>B is not A or B
    if (in_array($specified, "profilePicture") &&
        !in_array($specified, "profilePictureFilename")) {
        $messages[] = "profilePictureFilenameMissing";
    }

    if (!in_array($specified, "profilePicture") &&
        in_array($specified, "profilePictureFilename")) {
        $messages[] = "profilePictureMissing";
    }

    if (in_array($specified, "profilePicture") &&
        in_array($specified, "profilePictureFilename")) {
        try {
            $userManager->saveProfilePicture(
                $jsonQuery["username"],
                $jsonQuery["profilePicture"],
                $jsonQuery["profilePictureFilename"]
            );
        } catch (Exception $e) {
            $messages[] = "profilePictureServerSaveFailed";
        }
    }

    // Do not try to insert if we are running into issues
    if (!empty($messages)) {
        header("Content-type: application/json");
        $jsonAnswer += array("success" => "false");
        $jsonAnswer += array("messages" => $messages);
        echo json_encode($jsonAnswer);
        return;
    }

}


if (isset($_GET['action'])) {

    if ($_GET['action'] == 'register') {
        register();
    } else if ($_GET['action'] == 'registerValidate') {
        registerValidate();
    }

// If no action has been determined, go to home
} else {
    require(ROOT_CGI . '/view/home.php');
}
