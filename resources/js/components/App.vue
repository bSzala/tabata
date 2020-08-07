<template>
    <div class="container">
        <header class="header">
            <div class="header__content">
                <p>T2.0</p>
            </div>
        </header>
        <main class="content-section">
            <nav class="nav">

            </nav>
            <div class="tabata">
                <div class="tabata__timer">
                    <span>04:00</span>
                </div>
                <div class="tabata__additional">
                    <div class="tabata__cycles">
                        <h3 class="tabata__heading">Cycles</h3>
                        <span class="tabata__number" v-text="value1"></span>
                    </div>
                    <div class="tabata__tabatas">
                        <h3 class="tabata__heading">Tabatas</h3>
                        <span class="tabata__number" v-text="value2"></span>
                    </div>
                </div>

            </div>
        </main>
        <div class="sidebar">
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
        </div>
    </div>
</template>

<script>
    import TimerField from "./TimerField";
    import VueSlider from 'vue-slider-component';

    export default {
        components: {
            'timer-field': TimerField,
            'vue-slider': VueSlider
        },
        data(){
            return {
                value1: 8,
                value2: 1,
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
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
