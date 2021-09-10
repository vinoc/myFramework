<?php
//kd
class MemberManager extends BDD
{

    public function connectionLogin(string $login, string $password)
    {
        if ($login !== '0' OR $password !== '0') {
            $req = $this->_bdd;
            $resultat = $req->prepare('SELECT * FROM members WHERE login = ?');
            $resultat->execute([$login]);
            $data = $resultat->fetch(PDO::FETCH_ASSOC);

            if ($data == false) {
                return false;
            }

            $member = new Member($data);

            //if password work's, continue
            if (!password_verify($password, $member->getPassword())) {
                return false;
            }

            $member->setPasswordTemp(uniqid('', true));
            $this->memberUpdatePasswordTemp($member);

            setcookie('1234', $member->getId(), time() + 30 * 24 * 3600, '/', $_SERVER['HTTP_HOST'], false, true);
            setcookie('1235', $member->getPasswordTemp(), time() + 30 * 24 * 3600, '/', $_SERVER['HTTP_HOST'], false, true);

            $_SESSION['member'] = $data;

            return $member;
        } else {
            return false;
        }
    }

    public function connexionCookie(int $id, string $passwordTemp): object
    {
        if ($id !== '0' OR $passwordTemp !== '0') {

            $req = $this->_bdd;
            $resultat = $req->prepare('SELECT * FROM members WHERE id = ? AND passwordTemp = ?');
            $resultat->execute([$id, $passwordTemp]);
            $data = $resultat->fetch(PDO::FETCH_ASSOC);
            if ($data == false) {
                return new Member([]);
            }

            $_SESSION['member'] = $data;

            return new Member($data);
        }
        else {
            return new Member([]);
        }
    }

    public function newMember(object $member): bool
    {
        if ($member->getIdentify() !== false) {
            return false;
        }
        else {
            $password = password_hash($member->getPassword(), PASSWORD_DEFAULT);
            $saveNewMember = $this->_bdd->prepare('INSERT INTO members (login, mailAdress, password, permission, first_Date) VALUE (?, ?, ?, ?, ?)');
            return $saveNewMember->execute([$member->getLogin(), $member->getMailAdress(), $password, $member->getPermission(), date("d-m-y H:i:s")]);
        }
    }

    public function MemberUpdate(object $member, object $memberUpdate): bool
    {
        if ($memberUpdate->getPassword() != 'null') {
            $req = $this->_bdd->prepare(' UPDATE `members` SET `login`=:login, `mailAdress`=:mailAdress,`password`=:password WHERE `id`=:id');
            $req->bindValue(':password', password_hash($memberUpdate->getPassword(), PASSWORD_DEFAULT), PDO::PARAM_STR);
        }
        else {
            $req = $this->_bdd->prepare(' UPDATE `members` SET `login`=:login,`mailAdress`=:mailAdress WHERE `id`=:id');
        }

        $req->bindValue(':login', $memberUpdate->getLogin(), PDO::PARAM_STR);
        $req->bindValue(':mailAdress', $memberUpdate->getMailAdress(), PDO::PARAM_STR);
        $req->bindValue(':id', $member->getId(), PDO::PARAM_INT);

        return $req->execute();
    }

    public function memberUpdatePasswordTemp(object $member): bool
    {
        $req = $this->_bdd;
        $update = $req->prepare('UPDATE members SET passwordTemp = ? WHERE id = ?');
        return $update->execute([$member->getPasswordTemp(), $member->getId()]);
    }

    public function getMember($id)
    {
        if ($id == 0) {
            return new Member([]);
        }
        else {
            $req = $this->_bdd->prepare('SELECT `id`,`login`,`mailAdress`, `permission`,`first_date` FROM `members` WHERE id= :id');

            $req->bindValue(':id', $id, PDO::PARAM_INT);
            $req->execute();

            $member = $req->fetch();
            if ($member == false) {
                return false;
            } else {
                return new Member($member);

            }
        }
    }

    public function getMemberByLogin(string $login):object {
        $req= $this->_bdd->prepare('SELECT `id`,`login`,`mailAdress` FROM `members` WHERE `login` = :login');

        $req->bindValue(':login', $login, PDO::PARAM_STR);

        $req->execute();

        $data = $req->fetch();
        if($data == false){
            return new Member([]);
        }

        return new Member($data);
    }

    public function getMemberByMailAdress(string $mailAdress):object {
        $req= $this->_bdd->prepare('SELECT `id`,`login`,`mailAdress` FROM `members` WHERE `mailAdress` = :mailAdress');

        $req->bindValue(':mailAdress', $mailAdress, PDO::PARAM_STR);

        $req->execute();

        $data = $req->fetch();
        if($data == false){
            return new Member([]);
        }
        return new Member($data);
    }

    public function distractedMember(object $distractedUser, string $distractCode){
        $req = $this->_bdd->prepare('UPDATE `members` SET `distractedUser`=:disctractCode WHERE `id`= :id');
        $req->bindValue(':disctractCode', $distractCode, PDO::PARAM_STR);
        $req->bindValue(':id', $distractedUser->getID(), PDO::PARAM_INT);

        $req->execute();
    }

    public function findDistractedMemberByLinkCode($distractCode){
        $req = $this->_bdd->prepare('SELECT * FROM `members` WHERE `distractedUser`= :distractCode');

        $req->bindValue(':distractCode', $distractCode, PDO::PARAM_STR);

        $req->execute();

        $result = $req->fetch();
        return ($result==false) ? new Member([]): new Member($result);
    }

    public function changeDistractPassword(object $distractedMember){
        $password = password_hash($distractedMember->getPassword(), PASSWORD_DEFAULT);

        $req = $this->_bdd->prepare('UPDATE `members` SET `password`= :password, `distractedUser` = null WHERE `id`= :id');

        $req->bindValue(':password', $password, PDO::PARAM_STR);
        $req->bindValue(':id', $distractedMember->getID(), PDO::PARAM_INT);

        $req->execute();
    }

    public function noDoubleMember(string $login, string $mail): bool
    {
        $req = $this->_bdd->prepare('Select login, mailAdress FROM members WHERE login= :login OR mailAdress = :mail ');

        $req->bindValue(':login', $login, PDO::PARAM_STR);
        $req->bindValue(':mail', $mail, PDO::PARAM_STR);

        $req->execute();
        $antiDoublon = $req->fetch();

        if ($antiDoublon !=false) {
            if ($antiDoublon['login'] == $login) {
                $_SESSION['errors']['login'] = "Ce login est déjà pris ";
            }
            if ($antiDoublon['mail'] == $mail) {
                $_SESSION['errors']['mail'] = "Un compte existe déjà avec cette adresse mail.";
            }
            return true;
        }
        return false;
    }


}