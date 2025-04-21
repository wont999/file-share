<script>
export default {
    name: "Index",

    data(){
        return{
            auth: null
        }
    },

    mounted() {
        this.checkAuth()
    },

    updated(){
        this.checkAuth()
    },

    methods:{
        checkAuth(){
            this.auth=localStorage.getItem('authenticated')
        },

        logout(){
            axios.post('/logout')
                .then(response=>{
                    localStorage.removeItem('authenticated');
                    this.$router.push({name: 'user.login'})
                })
        }
    }
}
</script>

<template>
    <div>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <router-link class="navbar-brand" to="/">FileSharing</router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link class="nav-link" :class="{ active: $route.name === 'main' }" to="/">Главная</router-link>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <template v-if="!auth">
                            <li class="nav-item">
                                <router-link class="nav-link" :class="{ active: $route.name === 'user.login' }" to="/user/login">Вход</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link" :class="{ active: $route.name === 'user.registration' }" to="/user/registration">Регистрация</router-link>
                            </li>
                        </template>
                        <template v-else>
                            <li class="nav-item">
                                <router-link class="nav-link" :class="{ active: $route.name === 'user.personal' }" to="/user/personal">Личный кабинет</router-link>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" @click.prevent="logout">Выход</a>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            <div class="card">
                <div class="card-body">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.navbar {
    margin-bottom: 1rem;
}
</style>
