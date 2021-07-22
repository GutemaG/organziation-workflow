<template>
  <b-form-group
    id="fieldset-1"
    :description="description"
    :label="label"
    :label-for="labelFor"
    valid-feedback="Thank you!"
  >
    <input
      :id="id"
      :type="type"
      :required="required"
      v-on="listeners"
      :disabled="disabled"
      :placeholder="placeholder"
      class="form-control"
    />
    <!-- </input> -->
  </b-form-group>
</template>
<script>
export default {
  inheritAttrs: false,
  name: "base-input",
  props: {
    required: {
      type: Boolean,
      description: "Whether input is required (adds an asterix *)",
    },
    label: {
      type: String,
      description: "Input label (text before input)",
      required: true,
    },
    value: {
      type: [String, Number],
      description: "Input value",
    },
    type: {
      type: String,
      description: "Input type",
      default: "text",
    },
    id: {
      type: String,
      description: "input id",
      default: "",
    },
    labelFor: {
      type: String,
      description: "label-for",
      default: "",
    },
    name: {
      type: String,
      description: "Input name (used for validation)",
      default: "",
    },
    placeholder: {
      type: String,
      description: "place holder",
      default: "",
    },
    disabled: {
      type: Boolean,
      description: "place holder",
      default: false,
    },
    state: {
      type: Boolean,
      description: "state",
      default: false,
    },
    description: {
      type: String,
      description: "Description for input group",
      default: "",
    },
  },
  data() {
    return {
      focused: false,
    };
  },
  computed: {
    listeners() {
      return {
        ...this.$listeners,
        input: this.updateValue,
        focus: this.onFocus,
        blur: this.onBlur,
      };
    },
    slotData() {
      return {
        focused: this.focused,
      };
    },
  },
  methods: {
    updateValue(evt) {
      let value = evt.target.value;
      this.$emit("input", value);
    },
    onFocus(evt) {
      console.log(evt);
      this.focused = true;
    },
    onBlur(evt) {
      this.focused = false;
      this.$emit("blur", evt);
    },
  },
};
</script>
