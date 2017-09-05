<template>
  <div>
    <textarea class="form-control" :value="mdstr" @input="update" placeholder="可以使用markdown语法比如"></textarea>
    <!-- <textarea v-model="mdstr" placeholder="placeholder"></textarea> -->
    <div>
      <button class="btn btn-primary btn-sm" @click="reply()">回复</button>
    </div>
    <div class="form-control" style="height:auto;" v-html="compiledMarkdown"></div>
  </div>  
</template>

<script>
  // var _ = require('lodash');

  // import * as _ from 'lodash'
  import * as marked from 'marked'

  export default {
    props:['topic'],
    data(){
      return {
        input:'',
        mdstr:'',
        timmer:{
          running:false,
          continue:false,
        },
      }
    },
    computed: {
      compiledMarkdown: function () {
        // return 1
        return marked(this.mdstr, { sanitize: true })
      }
    },
    methods:{
      update(e) {
        if (this.timmer.running) {
          this.timmer.continue = true
          return
        }
        this.timmer.running = true;
        setTimeout(() => {
          this.timmer.running = false
          if (this.timmer.continue) {
            this.timmer.continue = false
            this.update(e)
          } else {
            this.mdstr = e.target.value
          }
          
        }, 1000);
        // this.input = e.target.value
        /*_.debounce(function (e) {
          this.input = e.target.value
        }, 300)*/
      },
      reply() {
        if (!this.$store.state.login.id) {
          alert('请登录');
          return 
        }

        axios.post('/topics/' + topic.id + '/replies', {
          body: this.mdstr,
          })
      }
    }
  }
</script>

<style scoped>
 
</style>