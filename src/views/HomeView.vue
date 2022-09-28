<template>
  <div class="container">
    <form action="#" class="p-3 bg-light border border-primary rounded main-form" @submit.prevent="sendData">
      <input-component v-for="item in inputs" :key="item.idx" :url="item" @deleteItemString="deleteItem"/>
      <div class="mb-3">
        <button type="button" class="btn btn-primary btn-plus" @click.prevent="addInput">+</button>
      </div>
      <div  class="invalid-feedback mb-1 d-block" ref="error-message" >
        <span v-if="showError"> {{errormessage}}</span>
      </div>
      <div class="mb-3">
        <button type="submit" class="btn btn-success m-2">Построить</button>
        <button type="submit" class="btn btn-dark m-2" @click.prevent="focusText" >Выделить</button>
        <button type="submit" class="btn btn-danger m-2" @click.prevent="deleteText">Очистить</button>
      </div>
    </form>
    <div class="selected-text mt-2">
      <textarea name="responce-text" id="responce-text" class="form-control"  cols="50" rows="10" ref="textInput" v-model="textData"></textarea>
    </div>
  </div>
</template>

<script>

import { v4 as uuidv4 } from 'uuid';
import InputComponent from "@/components/InputComponent";

export default {
  name: 'HomeView',
  components: {
    InputComponent
  },
  data(){
    return {
      inputs:[
        {
          idx: uuidv4(),
          value: ''
        }
      ],
      showError: false,
      errormessage: 'Не больше 10 URL!',
      textData: ''
    }
  },
  computed: {
    inputsCount(){
      return +this.inputs.length;
    },
    inputValues(){
      return this.inputs.map(item => item.value)
    }
  },
  mounted() {
    // router.push('home')
    console.log('mounted')
  },
  methods: {
    addInput(){
      if(this.inputsCount < 10){
        const newInput = {
          idx: uuidv4(),
          value: ''
        }
        this.inputs.push(newInput);
      } else {
        this.showError = true;
        setTimeout(() => {this.showError = false}, 2000)
      }
    },
    focusText(){
      this.$refs.textInput.select();
    },
    deleteText(){
      this.textData = '';
    },
    postData(url, body){
      return fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body),
      }).then(response => {
        if(!response.ok){
          throw new Error('No data')
        }
        return response.json();
      })
          .catch(error => {
            console.warn(error)
          })
    },
    sendData(){
      let body = this.inputValues;
      let textVal = this.$refs.textInput.value;
      console.log(this.textData.split('\n'));
      let request = {};
      request['arr'] = body;
      this.postData('request2' +
          '.php', request).then(data => {
        console.log(data);
        this.fallbackCopyTextToClipboard(data['text']);
        this.textData = data['text'];
        this.$refs.textInput.focus();
        this.$refs.textInput.select();
      });
    },
    deleteItem(idx){
      console.log(idx);
      if(this.inputsCount > 1){
        let index = this.inputs.findIndex(item => item.idx === idx);
        this.inputs.splice(index, 1);
      }

    },
    copyTextToClipboard(text){
      if (!navigator.clipboard) {
        this.fallbackCopyTextToClipboard(text);

        return;
      }
      navigator.clipboard.writeText(text).then(function() {
        console.log('Async: Copying to clipboard was successful!');
      }, function(err) {
        console.error('Async: Could not copy text: ', err);
      });
    },
    fallbackCopyTextToClipboard(text){
      let textArea = document.createElement("textarea");
      textArea.value = text;

      // Avoid scrolling to bottom
      textArea.style.top = "0";
      textArea.style.left = "0";
      textArea.style.position = "fixed";

      document.body.appendChild(textArea);
      textArea.focus();
      textArea.select();

      try {
        let successful = document.execCommand('copy');
        let msg = successful ? 'successful' : 'unsuccessful';
        // console.log('Fallback: Copying text command was ' + msg);
      } catch (err) {
        // console.error('Fallback: Oops, unable to copy', err);
      }

      document.body.removeChild(textArea);
    }
  }
}
</script>
<style>
.invalid-feedback{
  height: 21px;
  font-weight: 700;
}
#responce-text{
  width: 100%;
  overflow: scroll;
}
</style>
