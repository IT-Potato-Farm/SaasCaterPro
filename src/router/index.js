import { createRouter, createWebHistory } from 'vue-router';
import Landing_page from '../views/Landing_page.vue';  // Import your pages/components
import Register_page from '../views/authenticationfolder/Register_page.vue';
import Login_page from '../views/authenticationfolder/Login_page.vue';
import MenuAll_page from '../views/MenuAll_page.vue';

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
  { path: '/menu-all',
    component: MenuAll_page 
  },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
      return { top: 0, behavior: 'smooth' }; // This ensures it always scrolls to the top
    }
});
  
    export default router;