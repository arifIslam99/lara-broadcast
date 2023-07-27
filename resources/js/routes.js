import Dashboard from './components/Dashboard.vue';
import ListProducts from './pages/products/ListProducts.vue';
import ListUsers from './pages/users/ListUsers.vue';
export default[
    {
        path: '/admin/dashboard',
        name: 'admin.dashboard',
        component: Dashboard
    },
    {
        path: '/admin/products',
        name: 'admin.products',
        component: ListProducts
    },
    {
        path: '/admin/users',
        name: 'admin.users',
        component: ListUsers
    }
]