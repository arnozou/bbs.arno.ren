<template>
  <div class="row">
    <div class="col-md-10">
        <form class="form-horizontal" role="form" action="post">
          <div class="form-gourp">
            
          </div>
        </form>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        user:{},
      }
    },
    watch: {
      $route() {
        this.fetchData()
      }
    },
    created() {
      this.fetchData();
    },
    methods:{
      fetchData() {
        axios.get('/users/edit').then((response) => {
          console.log(response.headers, 1);
          this.user = response.data.data
        })
      }
    }
  }
</script>
