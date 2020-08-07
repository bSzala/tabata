<template>
    <div class="settings">
        <div class="setting">
            <span class="setting__title">Prepare</span>
            <timer-field></timer-field>
        </div>
        <div class="setting">
            <span class="setting__title">Work</span>
            <timer-field></timer-field>
        </div>
        <div class="setting">
            <span class="setting__title">Rest</span>
            <timer-field></timer-field>

        </div>
        <div class="setting">
            <span class="setting__title">Cycles</span>
            <vue-slider ref="slider" v-model="value1"  v-bind="options1" class="setting__slider"></vue-slider>
        </div>
        <div class="setting">
            <span class="setting__title">Tabatas</span>
            <vue-slider  ref="slider" v-model="value2"  v-bind="options2"  class="setting__slider"></vue-slider>
        </div>

        <div class="settings__buttons">
            <button class="btn btn--wide">Start</button>
        </div>
    </div>
</template>

<script>
import TimerField from "./TimerField";
import VueSlider from 'vue-slider-component';

export default {
    components: {
        'timer-field': TimerField,
        'vue-slider': VueSlider,
    },
    props:{
        cycles: Number,
        tabatas: Number
    },
    data: function(){
        return {
            value1: this.cycles,
            value2: this.tabatas,
            options1: {
                dotSize: 34,
                duration: 0.7,
                min:1,
                max:50,
                tooltip: 'always',
                tooltipPlacement: 'right',
                tooltipFormatter: void 0,
                useKeyboard: false,
                keydownHook: null,
                dragOnClick: false,
                enableCross: true,
                fixed: false,
                tooltipStyle: void 0,
                stepStyle: void 0,
                stepActiveStyle: void 0,
                labelStyle: void 0,
                labelActiveStyle: void 0,
                clickable: true,
            },
            options2: {
                dotSize: 34,
                duration: 0.7,
                min:1,
                max:50,
                tooltip: 'always',
                tooltipPlacement: 'left',
                tooltipFormatter: void 0,
                useKeyboard: false,
                keydownHook: null,
                dragOnClick: false,
                enableCross: true,
                fixed: false,
                tooltipStyle: void 0,
                stepStyle: void 0,
                stepActiveStyle: void 0,
                labelStyle: void 0,
                labelActiveStyle: void 0,
                clickable: true,
            }
        }
    },
    watch:{
        value1: function(value){
            this.$emit('changedCycle', value);
        },
        value2: function(value){
            this.$emit('changeTabatas',value);
        }
    },
    mounted() {
    }

}
</script>
