[1;33mdiff --git a/src/Model/User.php b/src/Model/User.php[m
[1;33mindex 8c6dd73..3f60209 100644[m
[1;33m--- a/src/Model/User.php[m
[1;33m+++ b/src/Model/User.php[m
[1;35m@@ -12,8 +12,12 @@[m [mclass User extends Entity[m
   private string $email;[m
   private string $password;[m
 [m
[1;32m+[m
[1;32m+[m
   /**[m
[1;31m-   * @return string[m
[1;32m+[m[1;32m   * Get the value of firstname[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @return  string[m
    */[m
   public function getFirstname()[m
   {[m
[1;35m@@ -21,15 +25,23 @@[m [mclass User extends Entity[m
   }[m
 [m
   /**[m
[1;31m-   * @param string $firstname[m
[1;32m+[m[1;32m   * Set the value of firstname[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @param  string  $firstname[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @return  self[m
    */[m
[1;31m-  public function setFirstname($firstname)[m
[1;32m+[m[1;32m  public function setFirstname(string $firstname)[m
   {[m
     $this->firstname = $firstname;[m
[1;32m+[m
[1;32m+[m[1;32m    return $this;[m
   }[m
 [m
   /**[m
[1;31m-   * @return string[m
[1;32m+[m[1;32m   * Get the value of lastname[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @return  string[m
    */[m
   public function getLastname()[m
   {[m
[1;35m@@ -37,15 +49,23 @@[m [mclass User extends Entity[m
   }[m
 [m
   /**[m
[1;31m-   * @param string $lastname[m
[1;32m+[m[1;32m   * Set the value of lastname[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @param  string  $lastname[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @return  self[m
    */[m
[1;31m-  public function setLastname($lastname)[m
[1;32m+[m[1;32m  public function setLastname(string $lastname)[m
   {[m
     $this->lastname = $lastname;[m
[1;32m+[m
[1;32m+[m[1;32m    return $this;[m
   }[m
 [m
   /**[m
[1;31m-   * @return string[m
[1;32m+[m[1;32m   * Get the value of username[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @return  string[m
    */[m
   public function getUsername()[m
   {[m
[1;35m@@ -53,10 +73,64 @@[m [mclass User extends Entity[m
   }[m
 [m
   /**[m
[1;31m-   * @param string $username[m
[1;32m+[m[1;32m   * Set the value of username[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @param  string  $username[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @return  self[m
    */[m
[1;31m-  public function setUsername($username)[m
[1;32m+[m[1;32m  public function setUsername(string $username)[m
   {[m
     $this->username = $username;[m
[1;32m+[m
[1;32m+[m[1;32m    return $this;[m
[1;32m+[m[1;32m  }[m
[1;32m+[m
[1;32m+[m[1;32m  /**[m
[1;32m+[m[1;32m   * Get the value of email[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @return  string[m
[1;32m+[m[1;32m   */[m
[1;32m+[m[1;32m  public function getEmail()[m
[1;32m+[m[1;32m  {[m
[1;32m+[m[1;32m    return $this->email;[m
[1;32m+[m[1;32m  }[m
[1;32m+[m
[1;32m+[m[1;32m  /**[m
[1;32m+[m[1;32m   * Set the value of email[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @param  string  $email[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @return  self[m
[1;32m+[m[1;32m   */[m
[1;32m+[m[1;32m  public function setEmail(string $email)[m
[1;32m+[m[1;32m  {[m
[1;32m+[m[1;32m    $this->email = $email;[m
[1;32m+[m
[1;32m+[m[1;32m    return $this;[m
[1;32m+[m[1;32m  }[m
[1;32m+[m
[1;32m+[m[1;32m  /**[m
[1;32m+[m[1;32m   * Get the value of password[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @return  string[m
[1;32m+[m[1;32m   */[m
[1;32m+[m[1;32m  public function getPassword()[m
[1;32m+[m[1;32m  {[m
[1;32m+[m[1;32m    return $this->password;[m
[1;32m+[m[1;32m  }[m
[1;32m+[m
[1;32m+[m[1;32m  /**[m
[1;32m+[m[1;32m   * Set the value of password[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @param  string  $password[m
[1;32m+[m[1;32m   *[m
[1;32m+[m[1;32m   * @return  self[m
[1;32m+[m[1;32m   */[m
[1;32m+[m[1;32m  public function setPassword(string $password)[m
[1;32m+[m[1;32m  {[m
[1;32m+[m[1;32m    $this->password = $password;[m
[1;32m+[m
[1;32m+[m[1;32m    return $this;[m
   }[m
 }[m
