<template>
  <v-select 
    label="text"
    :options="items"
    v-model="select"
    :placeholder="placeholder"
    @input="hasSelected"
    >
  </v-select>
  </template>

<script>
  import axios from 'axios'

  export default {
    props: ['placeholder','form','text','custom','selected'],
    data () {
      return {
        apigw: process.env.SIEP_API_GW_INGRESS || 'http://localhost:7777',
        select: '',
        items: [],

        loading: true,
        error: false,
        error_message: '',
      }
    },
    created: function () {
      this.select = this.selected;
      this.formOption();
    },
    methods: {
      onClear: function() {
        this.select = {
          text: null,
          value: null
        }
      },
      hasSelected: function (opt) {
        if(opt) {
          if(opt.value) {
            this.$emit('input',opt.value);
          }
        } else {
          this.$emit('input',null);
        }
      },
      formOption: function () {
        var vm = this;
        vm.loading = true;
        vm.error = false;

        const curl = axios.create({
          baseURL: vm.apigw
        });

        curl.get(vm.apigw+'/api/public/siep_admin/v1/forms/'+vm.form)
        .then(function (response) {
          let render = response.data.map(function(x) {
            let getValue = 'nombre';

            if (vm.custom) {
              getValue = vm.custom;
            } else {
              if (vm.text) {
                getValue = vm.text;
              }
            }
            return {
              text: x[vm.text || 'nombre'],
              value: x[getValue]
            };
          });

          vm.items = render;
          vm.loading = false;
        })
        .catch(function (error) {
          vm.error = true;
          vm.error_message = error.message;
          vm.loading = false;
        });
      },
    }
  }
</script>
<style>
.select2-result-repository{padding-top:4px;padding-bottom:3px}
.select2-result-repository__avatar img{width:100%;height:auto;border-radius:2px}
.select2-result-repository__title{color:black;font-weight:700;word-wrap:break-word;line-height:1.1;margin-bottom:4px}
.select2-result-repository__forks {margin-right:1em}
.select2-result-repository__forks {display:inline-block;color:#aaa;font-size:11px}
.select2-result-repository__description{font-size:13px;color:#777;margin-top:4px}
.select2-results__option--highlighted .select2-result-repository__title{color:white}
.select2-results__option--highlighted .select2-result-repository__forks,.select2-results__option--highlighted .select2-result-repository__description {color:#c6dcef}
</style>
