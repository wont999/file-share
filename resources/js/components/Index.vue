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
    <div class="container mt-4">
      <nav class="nav nav-pills mb-4">
        <!-- <router-link class="nav-link" :class="{ active: $route.name === 'get.index' }" :to="{name: 'get.index'}">Get</router-link> -->
        <router-link v-if="!auth" class="nav-link" :class="{ active: $route.name === 'user.login' }" :to="{name: 'user.login'}">Login</router-link>
        <router-link v-if="!auth" class="nav-link" :class="{ active: $route.name === 'user.registration' }" :to="{name: 'user.registration'}">Registration</router-link>
        <router-link v-if="auth" class="nav-link" :class="{ active: $route.name === 'user.personal' }" :to="{name: 'user.personal'}">Personal</router-link>
          <a v-if="auth" class="nav-link" @click.prevent="logout" href="#">Logout</a>
      </nav>
      <div class="card">
        <div class="card-body">
          <router-view></router-view>
        </div>
      </div>
    </div>
</template>

<style scoped>
.nav-link.active {
    background-color: #007bff;
    color: white;
}
.nav-link {
    color: #007bff;
    margin-right: 10px;
}
</style>
