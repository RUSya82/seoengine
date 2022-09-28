<template>
  <div class="container">
    <form action="#" class="p-3 bg-light border border-primary rounded main-form" @submit.prevent="sendData">
      <textarea name="response-refs" id="response-refs" class="form-control w-100 overflow-scroll" cols="50" rows="10"
                ref="responseRefs" v-model="sourceRefs"></textarea>
      <div class="invalid-feedback mb-1 d-block" ref="error-message">
        <span v-if="showError"> {{ errormessage }}</span>
      </div>
      <div class="mb-3">
        <button type="submit" class="btn btn-success m-2">Построить</button>
        <button type="submit" class="btn btn-dark m-2" @click.prevent="focusText">Выделить</button>
        <button type="submit" class="btn btn-danger m-2" @click.prevent="deleteText">Очистить</button>
      </div>
    </form>
    <div class="selected-text mt-2">
      <textarea name="responce-text" id="responce-text" class="form-control w-100 overflow-scroll" cols="50" rows="10"
                ref="textInput" v-model.trim="textData"></textarea>
    </div>
  </div>
</template>

<script>

import {v4 as uuidv4} from 'uuid';
import InputComponent from "@/components/InputComponent";
import router from "@/router";

export default {
  name: 'HomeView',
  components: {
    InputComponent
  },
  data() {
    return {
      inputs: [
        {
          idx: uuidv4(),
          value: ''
        }
      ],
      showError: false,
      errormessage: 'Не больше 10 URL!',
      textData: '',
      sourceRefs: '',
    }
  },
  computed: {},
  mounted() {
    console.log('mounted')
  },
  methods: {
    focusText() {
      this.$refs.textInput.select();
    },
    deleteText() {
      this.textData = '';
    },
    postData(url, body) {
      return fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body),
      }).then(response => {
        if (!response.ok) {
          throw new Error('No data')
        }
        return response.json();
      })
          .catch(error => {
            console.warn(error)
          })
    },
    sendData() {
      let body = this.sourceRefs.split('\n');
      body = body.map(item => item.trim());
      body = body.filter(item => item.length > 0);
      let request = {};
      request['arr'] = body;
      this.$router.push('result');
      this.postData('request2' +
          '.php', request)
          .then(data => {
            if (data['text']) {
              this.textData = data['text'];
            }

          })
          .then(data => {
            this.$router.push('result');
          });
    },
  }
}
</script>
<style>
.invalid-feedback {
  height: 21px;
  font-weight: 700;
}
</style>
