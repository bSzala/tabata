<template>
    <div class="timer-field">
        <input type="text" v-model="formatedTime"  class="timer-field__input" readonly/>
        <button class="timer-field__btn timer-field__btn--minus" @click="substract">-</button>
        <button class="timer-field__btn timer-field__btn--plus" @click="add">+</button>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                time: 2,
                formatedTime: '00:02'
            }
        },
        mounted() {
            this.styleTime();
        },
        methods: {
            substract(){
                if(this.time >1)
                    this.time--;

               this.styleTime();
            },
            add(){
               this.time++;
               this.styleTime();
            },
            styleTime(){
                this.formatedTime = new Date(this.time * 1000).toISOString().substr(11, 8);
            }
        }
    }
</script>
