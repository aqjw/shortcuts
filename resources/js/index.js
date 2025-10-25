import Mousetrap from 'mousetrap';

export default function shortcutInputComponent({ state, isDisabled, combinations, timeout }) {
    return {
        isRecording: false,
        recordedSequence: [],
        currentRecordedKeys: [],
        recordedCharacterKey: false,
        recordTimer: null,
        mousetrap: null,

        state,

        // Initialize Mousetrap instance for this component
        initMousetrap() {
            if (!this.mousetrap) {
                this.mousetrap = new Mousetrap(this.$el);
                this.mousetrap.recording = false;
            }
        },

        record() {
            if (this.isDisabled) {
                return;
            }

            this.initMousetrap();
            this.isRecording = true;
            this.recordedSequence = [];
            this.currentRecordedKeys = [];
            this.recordedCharacterKey = false;

            // Clear previous timer
            if (this.recordTimer) {
                clearTimeout(this.recordTimer);
                this.recordTimer = null;
            }

            // Start recording with Mousetrap
            this.mousetrap.recording = true;

            // Override handleKey temporarily
            const originalHandleKey = this.mousetrap.handleKey;
            const self = this;

            this.mousetrap.handleKey = function(character, modifiers, e) {
                if (!self.isRecording) {
                    return originalHandleKey.apply(this, arguments);
                }

                self.handleRecordedKey(character, modifiers, e);
            };
        },

        // Handle recorded key combinations
        handleRecordedKey(character, modifiers, e) {
            if (e.type === 'keydown') {
                if (character.length === 1 && this.recordedCharacterKey) {
                    this.recordCurrentCombo();
                }

                for (let i = 0; i < modifiers.length; i++) {
                    this.recordKey(modifiers[i]);
                }

                this.recordKey(character);
            } else if (e.type === 'keyup' && this.currentRecordedKeys.length > 0) {
                this.recordCurrentCombo();
            }
        },

        // Record a key into the current combination
        recordKey(key) {
            if (this.currentRecordedKeys.includes(key)) {
                return;
            }

            this.currentRecordedKeys.push(key);

            if (key.length === 1) {
                this.recordedCharacterKey = true;
            }
        },

        // Record the current combination and prepare for the next
        recordCurrentCombo() {
            if (this.currentRecordedKeys.length > 0) {
                this.recordedSequence.push([...this.currentRecordedKeys]);
                this.currentRecordedKeys = [];
                this.recordedCharacterKey = false;

                // Stop recording if max combinations reached
                if (this.recordedSequence.length >= combinations) {
                    this.finishRecording();
                    return;
                }

                this.restartRecordTimer();
            }
        },

        // Normalize sequence
        normalizeSequence(sequence) {
            for (let i = 0; i < sequence.length; i++) {
                sequence[i].sort((x, y) => {
                    if (x.length > 1 && y.length === 1) {
                        return -1;
                    } else if (x.length === 1 && y.length > 1) {
                        return 1;
                    }

                    return x > y ? 1 : -1;
                });

                sequence[i] = sequence[i].join('+');
            }
        },

        // Restart the recording timer
        restartRecordTimer() {
            if (this.recordTimer) {
                clearTimeout(this.recordTimer);
            }

            this.recordTimer = setTimeout(() => {
                this.finishRecording();
            }, timeout);
        },

        // Stop recording
        stop() {
            if (this.isDisabled) {
                return;
            }
            this.finishRecording();
        },

        // Finish recording and update state
        finishRecording() {
            this.isRecording = false;

            if (this.recordTimer) {
                clearTimeout(this.recordTimer);
                this.recordTimer = null;
            }

            if (this.mousetrap) {
                this.mousetrap.recording = false;
            }

            // Normalize sequence before saving
            if (this.recordedSequence.length > 0) {
                this.normalizeSequence(this.recordedSequence);
                this.state = this.recordedSequence.filter(key => key.trim() !== '');
            }

            // Reset state
            this.currentRecordedKeys = [];
            this.recordedCharacterKey = false;

            this.$el.blur();
        },

        // Clean up on destroy
        destroy() {
            if (this.mousetrap) {
                this.mousetrap.reset();
            }
            if (this.recordTimer) {
                clearTimeout(this.recordTimer);
            }
        },

        init() {
            this.initMousetrap();
        },

        input: {
            ['x-on:focus']: 'record()',
            ['x-on:blur']: 'stop()',
        },
    }
}
