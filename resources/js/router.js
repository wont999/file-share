import { createRouter, createWebHistory } from 'vue-router'

const routes = [
    // {
    //     path: '/get',
    //     component: () => import('./components/Get.vue'),
    //     name: 'get.index'
    // },
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
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next)=>{
    const auth = localStorage.getItem('authenticated')

    if(!auth){
        if(to.name==='user.login' || to.name==='user.registration'){
            return next()
        }
        else {
            return next({name: 'user.login'})
        }
    }

    if(auth && to.name==='user.login' || to.name ==='user.registration' ){
        return next({
            name: 'user.personal'
        })
    }

    next()
})

export default router
