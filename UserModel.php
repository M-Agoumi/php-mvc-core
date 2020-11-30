<?php
/**
 * UserModel.php
 * @author magoumi <agoumihunter@gmail.com>
 * Date : 11/26/2020
 * Time : 17:31
 */


namespace magoumi\phpmvc;


use magoumi\phpmvc\db\DbModel;

abstract class UserModel extends DbModel
{
	abstract public function getDisplayName(): string;
}