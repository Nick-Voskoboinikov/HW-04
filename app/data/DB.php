<?php

namespace App\data;

use RedBeanPHP\R;
use RedBeanPHP\RedException;

try {
  R::setup( 'pgsql:host=localhost;dbname=db.postgres', 'postgres', 'toor');
  if(!R::testConnection()){
    throw new RedException('No connection');
  }
}
catch(RedException $e){
  exit(var_dump($e));
}

class DB
{
  public static function getAll(string $strTable)
  {
    $strTable = self::testInput($strTable);
    return R::findAll($strTable);
    
  }

  public static function get(string $strId, string $strTable = 'user')
  {
    // TODO
  }
  
  public static function create(object $entity, string $strTable = 'user')
  {
    $bean = R::dispense($strTable);
    $bean->username = $entity->username;
    $bean->password = $entity->password;
    $bean->email = $entity->email;
    $bean->created = $entity->created;
    $bean->role = $entity->role;
    $bean->hash = '';

    $id = R::store($bean);

    return $id;
    }

    public static function update(object $obj, string $strTable = 'user')
    {
      // TODO
    }
    
    public static function delete(string $strId, string $strTable = 'user')
    {
      // TODO
    }
    public static function getAdminsNum(string $strTable = 'user')
    {
      return (int)((R::getAll('SELECT count(*) FROM "'.$strTable.'" WHERE "role" = \'5\';'))[0]["count"]);  // 0 - guest, 1 - user, 3 - editor, 5 - admin, 10 - ...whatever
    }
    public static function getUserByLogin(string $strUser, string $strTable = 'user')
    {
      return R::getRow('SELECT * FROM "'.$strTable.'" WHERE "username" = \''.$strUser.'\';');
    }
    public static function getUserByHash(string $strHash, string $strTable = 'user')
    {
      return R::getRow('SELECT "username" FROM "'.$strTable.'" WHERE "hash" ~ \''.$strHash.'\';');
    }
    public static function getUserByEmail(string $strEmail, string $strTable = 'user')
    {
      return R::getRow('SELECT * FROM "'.$strTable.'" WHERE "email" = \''.$strEmail.'\';');
    }
    public static function updateHash(string $strId, string $strHash, string $strTable = 'user')
    {
      // user can have multiple devices to log in from
      $strExistingHash=(R::getRow('SELECT "hash" FROM "'.$strTable.'" WHERE "id" = \''.$strId.'\';'))['hash'];
      $arrExistingHash=explode(';',$strExistingHash);
      if(count($arrExistingHash)==10){ // let's say 10 devices for logging in
        $arrExistingHash[0]=$strHash;
      } else {
        array_push($arrExistingHash,$strHash);
      }
      $strExistingHash=implode(';',$arrExistingHash);
      return R::exec( 'UPDATE "'.$strTable.'" SET "hash"=\''.$strExistingHash.'\' WHERE "id"=\''.$strId.'\';' );
    }
}
