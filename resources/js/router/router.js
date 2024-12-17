import { createRouter, createWebHistory } from "vue-router";
import { authMiddleware } from "../middlewares/authMiddleware";
import PageNotFound from "../pages/PageNotFound.vue";
import SignIn from "../pages/auth/SignIn.vue";
import SignUp from "../pages/auth/SignUp.vue";
import Dashboard from "../pages/Dashboard.vue";
import Business from "../pages/businesses/Business.vue";
import BusinessCreate from "../pages/businesses/Create.vue";
import BusinessEdit from "../pages/businesses/Edit.vue";
import BusinessView from "../pages/businesses/View.vue";
import BusinessArchive from "../pages/businesses/Archive.vue";
import Request from "../pages/requests/Request.vue";
import RequestCreate from "../pages/requests/Create.vue";
import RequestView from "../pages/requests/View.vue";
import RequestEdit from "../pages/requests/Edit.vue";
import RequestArchive from "../pages/requests/Archive.vue";
import Requirements from "../pages/requests/Requirements.vue";
import Profile from "../pages/Profile.vue";
import Verification from "../pages/Verification.vue";
import Users from "../pages/users/Users.vue";

const routes = [
    {
        path: '/:pathMatch(.*)*',
        component: PageNotFound,
        meta: { Layout: false, requiresAuth: false }
    },
    {
        name: 'sign-in',
        path: '/sign-in',
        component: SignIn,
        meta: { Layout: false, requiresGuest: true }
    },
    {
        name: 'sign-up',
        path: '/sign-up',
        component: SignUp,
        meta: { Layout: false, requiresGuest: true }
    },
    {
        name: 'dashboard',
        path: '/',
        component: Dashboard,
        meta: { Layout: true, requiresAuth: true, verifiedOnly: true }
    },
    {
        name: 'business',
        path: '/business',
        component: Business,
        meta: { Layout: true, requiresAuth: true, verifiedOnly: true }
    },
    {
        name: 'business-create',
        path: '/business/create',
        component: BusinessCreate,
        meta: { Layout: true, requiresAuth: true, verifiedOnly: true }
    },
    {
        name: 'business-edit',
        path: '/business/edit/:business_id',
        component: BusinessEdit,
        meta: { Layout: true, requiresAuth: true, verifiedOnly: true }
    },
    {
        name: 'business-view',
        path: '/business/view/:business_id',
        component: BusinessView,
        meta: { Layout: true, requiresAuth: true, verifiedOnly: true }
    },
    {
        name: 'business-archive',
        path: '/business/archive',
        component: BusinessArchive,
        meta: { Layout: true, requiresAuth: true, verifiedOnly: true }
    },
    {
        name: 'request',
        path: '/request',
        component: Request,
        meta: { Layout: true, requiresAuth: true, verifiedOnly: true }
    },
    {
        name: 'request-create',
        path: '/request/create/:business_id?',
        component: RequestCreate,
        meta: { Layout: true, requiresAuth: true, verifiedOnly: true }
    },
    {
        name: 'request-view',
        path: '/request/view/:request_id?',
        component: RequestView,
        meta: { Layout: true, requiresAdmin: true, verifiedOnly: true }
    },
    {
        name: 'request-edit',
        path: '/request/edit/:request_id?',
        component: RequestEdit,
        meta: { Layout: true, requiresAdmin: true, verifiedOnly: true }
    },
    {
        name: 'request-archive',
        path: '/request/archive',
        component: RequestArchive,
        meta: { Layout: true, requiresAdmin: true, verifiedOnly: true }
    },
    {
        name: 'requirements',
        path: '/request/requirements/:requirement_id',
        component: Requirements,
        meta: { Layout: true, requiresAuth: true, verifiedOnly: true }
    },
    {
        name: 'profile',
        path: '/profile',
        component: Profile,
        meta: { Layout: true, requiresAuth: true, verifiedOnly: true }
    },
    {
        name: 'users',
        path: '/users',
        component: Users,
        meta: { Layout: true, requiresAuth: true, verifiedOnly: true }
    },
    {
        name: 'verification',
        path: '/verification',
        component: Verification,
        meta: { requiresAuth: true }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach(authMiddleware);

export default router;