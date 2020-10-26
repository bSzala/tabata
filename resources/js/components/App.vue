<template>
    <div class="container">
        <header-element></header-element>
        <main class="content-section">
            <audio id="beep-sound">
                <source src="sounds/beep-08b.mp3" type="audio/mpeg">
                <source src="sounds/beep-08b.wav" type="audio/wav">
                <source src="sounds/beep-08b.ogg" type="audio/ogg">
            </audio>
            <audio id="count-start">
                <source src="sounds/whistle.mp3" type="audio/mpeg">
                <source src="sounds/whistle.wav" type="audio/wav">
            </audio>
            <audio id="done-sound">
                <source src="sounds/cheering.mp3" type="audio/mpeg">
                <source src="sounds/cheering.wav" type="audio/wav">
            </audio>

            <div class="tabata">
                <div class="tabata__additional">
                    <div class="tabata__cycles">
                        <h3 class="tabata__heading">Cycles</h3>
                        <span class="tabata__number" >{{currentCycle}}/{{cycles}}</span>
                    </div>
                    <div class="tabata__tabatas">
                        <h3 class="tabata__heading">Tabatas</h3>
                        <span class="tabata__number" >{{currentTabata}}/{{tabatas}}</span>
                    </div>
                </div>
                <div class="tabata__timer">
                    <h3 class="tabata__title" v-text="timerTitle"></h3>
                    <span>{{prettyTimer}}</span>
                </div>
                <div class="tabata__controls">
                    <button class="btn btn-control" v-if="pauseActive" @click="pauseBtn"  v-text="!resumeCurrent? 'Pause':'Resume'" ref="pauseBtn"></button>
                    <button class="btn btn-control btn-control--green" @click="toggleWorkout" v-show="!isWorking">Start</button>
                </div>

            </div>

        </main>
        <div class="sidebar" v-show="showSidebar">
            <settings
                ref="settings"
                v-bind:cycles="cycles"
                v-bind:tabatas="tabatas"
                v-bind:prepareTime="prepareTimeSecond"
                v-bind:workTime="workTimeSecond"
                v-bind:restTime="restTimeSecond"
                v-bind:displayTimer="prettyTimer"
                :actionDisabled="actionDisabled"
                @changedCycle="updateCycle"
                @changeTabatas="updateTabatas"
                @changeTime="updateTime"
                @workout="startWorkout"
                @pause="pauseWorkout"
            ></settings>
        </div>
        <nav class="nav">
            <button class="nav__item" @click="toggleSidebar"><i class="fas fa-bars"></i> Config</button>
        </nav>

    </div>
</template>

<script>
    import Header from "./Header";
    import Settings from "./Settings";
    import BodyTypeManager from "./../utilities/body-type-manager";
    import Beep from './../utilities/audio-manager';

    export default {
        components: {
            'header-element': Header,
            'settings': Settings
        },
        props:{
            tabataCycle: Number,
            tabataCounter: Number,
            prepare: Number,
            work: Number,
            rest: Number,
        },
        data(){
            return {
                cycles: this.tabataCycle,
                tabatas: this.tabataCounter,
                prepareTimeSecond: this.prepare,
                workTimeSecond: this.work,
                restTimeSecond: this.rest,
                timer: 0,
                prettyTimer:'',
                workoutInterval:false,
                currentTabata: 0,
                doneStep: 0,
                tabataSteps: 0,
                timerTitle: '',
                currentCycle: 1,
                audio: null,
                showSidebar: false,
                pauseActive: false,
                resumeCurrent: false,
                isWorking: false,
                actionDisabled: false,
                finished: false,
            }
        },
        mounted() {
            this.init();
            this.loadBackspaceEvent();
        },
        methods: {
            loadBackspaceEvent(){
                document.addEventListener('keypress',e => {
                    console.warn('key: '+e.code);
                    if(e.code.toLowerCase() === 'space'){
                        const btn = this.$refs.pauseBtn;
                        btn.click();
                    }
                    if(e.code.toLowerCase() === 'enter'){
                        BodyTypeManager.releasePause();
                        this.toggleWorkout();

                    }
                });
            },
            init(){
                this.currentTabata = 0;
                this.doneStep=0;
                this.finished=false;
                this.cycles=this.tabataCycle;
                this.tabatas=this.tabataCounter;
                this.prepareTimeSecond=this.prepare;
                this.workTimeSecond=this.work;
                this.restTimeSecond=this.rest;
                this.updateTimerTitle('');
                this.countSteps();
                this.displayCycle(1);
                this.displayTabata(1);
                this.updateTimer();
                this.styleTimer();
                BodyTypeManager.setGlobalType(BodyTypeManager.Types.INIT);
                this.audio = new Beep('beep-sound');
            },
            toggleSidebar(){
                this.showSidebar = !this.showSidebar;
            },
            toggleWorkout(){
                this.isWorking = !this.isWorking;
                this.$refs.settings.toggleWorkout();
            },
            countSteps(){
                this.tabataSteps = 1 + (this.cycles*2);
            },
            updateCycle(cycle){
                this.cycles = cycle;
                this.displayCycle(1);
                this.updateTimer();
                this.countSteps();
            },
            updateTabatas(tabatas){
                this.tabatas = tabatas;
                this.updateTimer();
                this.displayTabata(1);
                this.countSteps();
            },
            updateTimer(){
                const cycleWorkingTime = (this.cycles * this.workTimeSecond);
                const cycleBreakTime = (this.cycles*this.restTimeSecond);
                const singleTabataTime = this.prepareTimeSecond + cycleWorkingTime + cycleBreakTime;
                this.timer = singleTabataTime* this.tabatas;
                this.styleTimer();
            },
            styleTimer(){
                this.prettyTimer = new Date(this.timer * 1000).toISOString().substr(11, 8);
            },
            updateTimerTitle(title){
                this.timerTitle = title;
            },
            updateTime(obj){
                const seconds = obj.seconds;
                switch (obj.type){
                    case 'prepare':
                        this.prepareTimeSecond = seconds;
                        break;
                    case 'work':
                        this.workTimeSecond = seconds;
                        break;
                    case 'rest':
                        this.restTimeSecond = seconds;
                        break;
                    default:
                        throw Error('Not supported!');
                }

                this.updateTimer();
            },
            pauseWorkout(){
                if(this.workoutInterval){
                    clearInterval(this.workoutInterval);
                    this.workoutInterval= false;
                    this.resumeCurrent = true;
                }else{
                    this.runInterval();
                    this.resumeCurrent=false;
                }
                BodyTypeManager.pauseToggle();
            },
            pauseBtn(){
                this.$refs.settings.pauseWorkout();
            },
            runPrepare(){
                this.timer = this.prepareTimeSecond;
                this.styleTimer();
                this.displayCycle(0);
                this.updateTimerTitle('Prepare');
                BodyTypeManager.setGlobalType(BodyTypeManager.Types.PREPARE);
                this.runInterval();
            },
            finishTabata(){
                this.doneStep=0;
                BodyTypeManager.setGlobalType(BodyTypeManager.Types.DONE);
                if(this.currentTabata === this.tabatas){
                    this.prettyTimer = 'Done!';
                    this.finished = true;
                    this.updateTimerTitle('');
                    this.$refs.settings.toggleWorkout();
                }else{
                    this.workoutAction(true);
                    this.currentTabata++;
                }

            },
            isWorkStep(){
                return Math.abs(this.doneStep % 2) == 1;
            },
            runWork(){
                this.timer = this.workTimeSecond;
                this.styleTimer();
                this.updateTimerTitle('Work');
                BodyTypeManager.setGlobalType(BodyTypeManager.Types.WORK);
                this.currentCycle++;
                this.runInterval();
            },
            runBreak(){
                this.timer = this.restTimeSecond;
                this.styleTimer();
                this.updateTimerTitle('Break');
                BodyTypeManager.setGlobalType(BodyTypeManager.Types.REST);
                this.runInterval();
            },
            displayCycle(currentCycle){
                this.currentCycle = currentCycle;
            },
            displayTabata(tabata){
                this.currentTabata = tabata;
            },
            startWorkout(status){
                this.currentTabata=1;
                this.showSidebar=false;
                this.isWorking=status;
                this.pauseActive=status;
                this.actionDisabled=status;
                this.workoutAction(status);
                if(!status){
                    if(!this.finished){
                        this.init();
                        BodyTypeManager.releasePause();
                    }
                }
            },
            workoutAction(active){
                if(active) {
                    //started
                    if (this.doneStep === 0) {
                        this.runPrepare();
                    } else if (this.doneStep === this.tabataSteps) {
                        this.finishTabata();
                    } else if (this.isWorkStep()) {
                        this.runWork();
                    } else {
                        this.runBreak();
                    }
                }else{
                    //stopped
                    this.clearInterval();
                }
            },
            handleAudio(timeInSeconds){
                var count_audio = new Beep('count-start');

                if((BodyTypeManager.hasType(BodyTypeManager.Types.WORK) && this.timer >= this.workTimeSecond) ||
                    (BodyTypeManager.hasType(BodyTypeManager.Types.REST) && this.timer >= this.restTimeSecond)
                ){
                    count_audio.play();
                }

                if(BodyTypeManager.hasType(BodyTypeManager.Types.DONE)){
                    let done_audio = new Beep('done-sound');
                    done_audio.play();
                }

                if(timeInSeconds <= 3 && timeInSeconds > 0){
                    this.audio.play();
                }

            },
            runInterval(){
                if(this.workoutInterval){
                    return;
                }

                this.workoutInterval = setInterval(()=> {



                    if(this.timer >1){
                        this.timer--;
                        this.styleTimer();
                    }else{
                        this.clearInterval();
                        this.doneStep++;
                        this.workoutAction(true);
                    }
                    this.handleAudio(this.timer);

                },1000);
            },
            clearInterval(){
                clearInterval(this.workoutInterval);
                this.workoutInterval = false;
            },

        }
    }
</script>
