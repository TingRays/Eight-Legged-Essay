<?php
// 产品角色
class User{
	protected $name = '';
	protected $age = '';
	protected $sex = '';
 
	public function setName($name){
		$this->name = $name;
	}
 
	public function setAge($age){
		$this->age = $age;
	}
 
	public function setSex($sex){
		$this->sex = $sex;
	}
 
	public function getUser(){
		echo '这个人姓名是：' . $this->name 
		. '，年龄是：' . $this->age
		. '，性别是：' . $this->sex .'。<br>';
	}
}
 
// 抽象建造者
interface UserBuilder{
	public function builderName();
	public function builderAge();
	public function builderSex(); 
	
	public function getUser();
}
 
// 具体建造者
class CommonBuilder implements UserBuilder{
	public $user;
 
	public function __construct(){
		$this->user = new User();
	}
 
	public function builderName(){
		$this->user->setName('普通用户');
	}
 
	public function builderAge(){
		$this->user->setAge('20');
	}
 
	public function builderSex(){
		$this->user->setSex('男');
	}
 
	public function getUser(){
		return $this->user;
	}
}
 
// 具体建造者
class SupperBuilder implements UserBuilder{
	public $user;
 
	public function __construct(){
		$this->user = new User();
	}
 
	public function builderName(){
		$this->user->setName('超级用户');
	}
 
	public function builderAge(){
		$this->user->setAge('30');
	}
 
	public function builderSex(){
		$this->user->setSex('女');
	}
 
	public function getUser(){
		return $this->user;
	}
}
 
// 指挥者
class UserDirector{
	public function make(UserBuilder $builder){
		$builder->builderName();
		$builder->builderAge();
		$builder->builderSex();
		return $builder->getUser();
	}
}
 
$director = new UserDirector();
$commonBuilder = new CommonBuilder();
$commonUser = $director->make($commonBuilder);
$commonUser->getUser();
 
$supperBuilder = new SupperBuilder();
$supperUser = $director->make($supperBuilder );
$supperUser->getUser();