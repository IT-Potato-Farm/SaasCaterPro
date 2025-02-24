import { createRouter, createWebHistory } from 'vue-router';
import Landing_page from '../views/Landing_page.vue';  // Import your pages/components
import Register_page from '../views/authenticationfolder/Register_page.vue';
import Login_page from '../views/authenticationfolder/Login_page.vue';
import MenuAll_page from '../views/MenuAll_page.vue';
import Cart_page from '../views/Cart_page.vue';
import Orderdetails_page from '../views/Orderdetails_page.vue';
import Checkout_page from '../views/Checkout_page.vue';
import Dashboard_page from '../views/Dashboard_page.vue';
import Ultimatepackage_page from '../views/Ultimatepackage_page.vue';

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
  { path: '/cart',
    component: Cart_page 
  },
  { path: '/order-details',
    component: Orderdetails_page 
  },
  { path: '/checkout',
    component: Checkout_page 
  },
  { path: '/dashboard',
    component: Dashboard_page 
  },
  { path: '/ultimate-package',
    component: Ultimatepackage_page
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