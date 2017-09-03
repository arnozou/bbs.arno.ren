<template>
   <ol class="breadcrumb">
    <li><router-link to='/'>Home</router-link></li>
    <li v-for="(item, index) in paths">
      <router-link :to="'/' + item" v-text="paths[index]"></router-link>
    </li>
  </ol>
</template>

<script>
  export default {
    data() {
      return {
        // second: 'example',
        // third: 'example',
        paths:[],
      }
    },
    watch: {
      '$route': 'fetchRoute'
    },
    methods: {
      fetchRoute() {
        console.log(this.$route);
        this.paths = this.$route.path.split('/');
        if (this.paths[0] == '') {
          this.paths.shift();
        }
        
      }
    },
    computed: {
      second() {
        return this.paths[1] ? '/' + this.paths[1] : false;
      },
      third() {
        return this.paths[2] ? this.paths.slice(0, 3).join('/') : false;
      },
      route() {
        var arr = []
        for (var i = this.paths.length - 1; i >= 0; i--) {
          arr[i] = this.paths.slice(0, i+1).join('/')
        }
        return arr;
      }
    }
  }
</script>