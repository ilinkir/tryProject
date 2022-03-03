<template>
  <Disclosure as="div" class="border-b border-gray-200 py-6">
    <h3 class="-my-3 flow-root">
      <DisclosureButton
        class="py-3 bg-white w-full flex items-center justify-between text-sm text-gray-400 hover:text-gray-500"
        v-slot="{ open }"
      >
        <span class="font-medium text-gray-900">
          {{ title }}
        </span>
        <span class="ml-6 flex items-center">
          <PlusSmIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
          <MinusSmIcon v-else class="h-5 w-5" aria-hidden="true" />
        </span>
      </DisclosureButton>
    </h3>
    <DisclosurePanel class="pt-6">
      <div class="space-y-4">
        <div
          v-for="listValue in values"
          :key="getValueId(listValue.id)"
          class="flex items-center"
        >
          <Checkbox
            :id="getValueId(listValue.id)"
            v-model="state"
            :val="listValue.id"
            :label="listValue.name"
            :disabled="false"
            @update:modelValue="onInput"
          />
        </div>
      </div>
    </DisclosurePanel>
  </Disclosure>
</template>

<script>
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { MinusSmIcon, PlusSmIcon } from "@heroicons/vue/solid";
import Checkbox from "@/components/global/checkbox.vue";

export default {
  props: {
    id: {
      type: String,
      default: null,
    },
    title: {
      type: String,
      default: null,
    },
    hasSingle: { type: Boolean, default: false },
    values: { type: Array, default: () => [] },
    modelValue: { type: Array, default: () => [] },
  },
  data() {
    return {
      checkedProxy: false,
    };
  },
  components: {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    MinusSmIcon,
    PlusSmIcon,
    Checkbox,
  },
  computed: {
    state: {
      get : (vm) => vm.modelValue,
      set : (values) => values,
    },
  },
  methods: {
    onInput(event) {
      this.$emit('update:modelValue', event)
    },
    getValueId(id) {
      return this.id ? `${this.id}_${id}` : id;
    },
  },
};
</script>
