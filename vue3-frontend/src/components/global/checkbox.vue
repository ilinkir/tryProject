<template>
  <div
      :class="[
      'form-control form-control_checkbox',
      {
        ['has-color']: hasColor,
        ['is-disabled']: disabled,
        ['is-empty']: !hasLabel,
        ['is-switch']: isSwitch,
        ['is-transparent']: isTransparent,
      },
    ]"
  >
    <input
        :id="id"
        v-model="checked"
        type="checkbox"
        :class="[
        'checkbox',
        {
          ['has-color']: hasColor,
        },
      ]"
        :name="name"
        :value="val"
        :disabled="disabled"
        @change="onChange"
        @click="onClick"
    />
    <label class="text-s2i" :for="id">
      <figure v-if="hasColor" :style="background" />
      <span v-if="hasLabel" v-html="label" />
      <slot />
    </label>
  </div>
</template>

<script>
export default {
  props: {
    name: {
      type    : String,
      default : () => '',
    },
    disabled: {
      type    : [String, Boolean],
      default : false,
    },
    id: {
      type    : [String, Number],
      default : () => '',
    },
    label: {
      type    : [String, Number],
      default : () => '',
    },
    val: {
      type    : [String, Number, Boolean, Object],
      default : () => false,
    },
    modelValue: {
      type    : [String, Number, Array, Boolean],
      default : () => false,
    },
    hasColor : { type: Boolean, default: false },
    hasLabel : { type: Boolean, default: true },
    image    : {
      type    : String,
      default : () => '',
    },
    hex: {
      type    : String,
      default : () => '',
    },
    smallText     : { type: Boolean, default: true },
    isSwitch      : { type: Boolean, default: false },
    isTransparent : { type: Boolean, default: false },
  },

  data() {
    return {
      checkedProxy: false,
    };
  },

  computed: {
    checked: {
      get() {
        return this.modelValue;
      },
      set(val) {
        this.checkedProxy = val;
      },
    },
    background() {
      if (this.image) {
        return { backgroundImage: `url(${this.image})` };
      }
      if (this.hex) {
        return { backgroundColor: this.hex };
      }

      return {};
    },
  },

  emits: ["update:modelValue"],

  methods: {
    onChange() {
      this.$emit("update:modelValue", this.checkedProxy);
    },
    onClick(e) {
      this.$emit('click', e);
    },
  },
};
</script>
