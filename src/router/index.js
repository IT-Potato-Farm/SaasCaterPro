import { createRouter, createWebHistory } from 'vue-router';
import Landing_page from '../views/Landing_page.vue';  // Import your pages/components
import Register_page from '../views/authenticationfolder/Register_page.vue';
import Login_page from '../views/authenticationfolder/Login_page.vue';

const routes = [
  {
    path: '/',
    component: Landing_page
  },
  { path: '/login',
    component: Login_page 
  },
  { path: '/register',
    component: Register_page 
  },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});
  
    export default router;