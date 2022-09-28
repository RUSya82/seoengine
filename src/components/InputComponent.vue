<template>
<div class="inputs-wrapper">
<div class="mb-3 first-input d-flex">
  <input type="text" class="form-control main-input" v-model.trim="url.value" :name="`url_${url.idx}`"
         placeholder="Введите адрес">
  <button class="btn delete-btn btn-danger" @click.prevent="onEmmit(url.idx)">-</button>
</div>
</div>
</template>
<script>
export default {
  props: {
    url: {
      type: Object,
      required: true
    }
  },
  methods: {
    onEmmit(id){
      this.$emit('deleteItemString', id);
    }
  }
}
</script>