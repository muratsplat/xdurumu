<?php

use Illuminate\Database\Seeder;

use App\User;

class createAdminUser extends Seeder
{
    
    /**
     * Admin User's attributes
     */
    private  $name   = "vatandasRiza";       
    private  $pass   = 'evrimOlmazsaDevrimOlur';
    private  $email  = 'murat.asya@gmail.com';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( $this->adminUserIsExist()) {
            
               $this->command->warn('Admin kullanıcı daha önce oluşturulmuş !');
               
               return;
        }
        
        $this->createAdmin();      
    }
    
    
    /**
     * Determine if admin user already is exist.
     * 
     * @return bool
     */
    private function adminUserIsExist()
    {     
        $empty  =  User::query()
                
                        ->where('name', $this->name)
                        
                        ->get()
                
                        ->isEmpty();
        
        return  ! $empty;
    }
    
    
    /**
     * To create admin user to access admin panel
     * 
     * @return void
     */
    private function createAdmin()
    {       
        $user = User::create([
                'name'      => $this->name,
                'email'     => $this->email,
                'password'  => bcrypt($this->pass),
            ]);
        
       
        $msg = "Kullanıcı ismi '$user->name', şifre '$this->pass', e-posta adresi ise"
                . " '$this->email' 'dir.";
        
        $this->command->info('Kullanıcı oluşturuldu.');
        
        $this->command->info($msg);              
    }
}
