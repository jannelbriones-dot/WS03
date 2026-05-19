<?php
    namespace framework\Middleware;

    use framework\Session;
    use framework\Authorization;

    class Authorize {
        /**
         * @return bool
         */
        public function isAuthenticated() {
            return Session::has('user');
        }

        public function handle($role){
    
        if($role === 'guest' && $this->isAuthenticated()) {
            return redirect('/');
        } elseif($role === 'auth' && $this->isAuthenticated()) {
    return redirect('/auth/login');
        }
        }}