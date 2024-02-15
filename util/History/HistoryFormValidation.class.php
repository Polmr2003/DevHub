<?php

require_once "util/History/HistoryMessage.class.php";

/**
 * Class used to validate user's input form for an History object
 * (most patterns taken from regexpal.com)
 */
class HistoryFormValidation
{
    public const INSERT = array("idPet");
    public const UPDATE = array("id", "date");
    public const SELECT = array("id");
    public const DELETE = array("id");

    public static function checkData ($requiredFields)
    {
        $id = " ";
        $idPet = " ";
        $date = " ";
        $motive = " ";
        $desc = " ";

        if (isset($_POST["id"])) $id = $_POST["id"];
        if (isset($_POST["idpet"])) $idPet = $_POST["idpet"];
        if (isset($_POST["date"])) $date = $_POST["date"];
        if (isset($_POST["motive"])) $motive = $_POST["motive"];
        if (isset($_POST["desc"])) $desc = $_POST["desc"];
        
        $idRequired = in_array("id", $requiredFields);
        $idPetRequired = in_array("idPet", $requiredFields);
        $dateRequired = in_array("date", $requiredFields);
        $motiveRequired = in_array("motive", $requiredFields);
        $descRequired = in_array("desc", $requiredFields);

        if ($id != " " || $idRequired)
        {
            $id = htmlspecialchars(trim($id));
            $pattern = '/^\d+$/';
            if      (empty($id) && $idRequired)                 $_SESSION["error"][] = HistoryMessage::FORM_EMPTY_ID;
            else if (!empty($id) && !preg_match($pattern, $id)) $_SESSION["error"][] = HistoryMessage::FORM_INVALID_ID;
        }

        if ($idPet != " " || $idPetRequired)
        {
            $idPet = htmlspecialchars(trim($idPet));
            $pattern = '/^\d+$/';
            if      (empty($idPet) && $idPetRequired)                 $_SESSION["error"][] = HistoryMessage::FORM_EMPTY_IDPET;
            else if (!empty($idPet) && !preg_match($pattern, $idPet)) $_SESSION["error"][] = HistoryMessage::FORM_INVALID_IDPET;
        }

        if ($date != " " || $dateRequired)
        {
            $date = htmlspecialchars(trim($date));
            $pattern = "/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/";
            if      (empty($date) && $dateRequired)                 $_SESSION["error"][] = HistoryMessage::FORM_EMPTY_DATE;
            else if (!empty($date) && !preg_match($pattern, $date)) $_SESSION["error"][] = HistoryMessage::FORM_INVALID_DATE;
        }

        if ($motive != " " || $motiveRequired)
        {
            $motive = htmlspecialchars(trim($motive));
            //$pattern = anything is valid
            if      (empty($motive) && $motiveRequired)                 $_SESSION["error"][] = HistoryMessage::FORM_EMPTY_MOTIVE;
            //else if (!empty($motive) && !preg_match($pattern, $motive)) $_SESSION["error"][] = HistoryMessage::FORM_INVALID_MOTIVE;
        }

        if ($desc != " " || $descRequired)
        {
            $desc = htmlspecialchars(trim($desc));
            //$pattern = anything is valid
            if      (empty($desc) && $descRequired)                 $_SESSION["error"][] = HistoryMessage::FORM_EMPTY_DESC;
            //else if (!empty($desc) && !preg_match($pattern, $desc)) $_SESSION["error"][] = HistoryMessage::FORM_INVALID_DESC;
        }

        return new History($id, $idPet, $date, $motive, $desc);
    }
}