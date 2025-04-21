import { createRouter, createWebHistory } from 'vue-router'

const routes = [
    {
        path: '/',
        component: () => import('./components/Main.vue'),
        name: 'main'
    },
    {
        path: '/main',
        component: () => import('./components/Main.vue'),
        name: 'main'
    },
    {
        path: '/user/login',
        component: () => import('./components/Login.vue'),
        name: 'user.login'
    },
    {
        path: '/user/registration',
        component: () => import('./components/Registration.vue'),
        name: 'user.registration'
    },
    {
        path: '/user/personal',
        component: () => import('./components/Personal.vue'),
        name: 'user.personal'
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: { name: 'main' }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const auth = localStorage.getItem('authenticated')

    if (to.name === 'main') {
        return next()
    }

    if(!auth){
        if(to.name==='user.login' || to.name==='user.registration'){
            return next()
        }
        return next({ name: 'user.login' })
    }

    if (auth) {
        if (to.name === 'user.login' || to.name === 'user.registration') {
            return next({ name: 'user.personal' })
        }
    }

    next()
})

export default router
