<template>
  <div>
  <!-- Mobile filter dialog -->
  <TransitionRoot as="template" :show="mobileFiltersOpen">
    <Dialog as="div" class="fixed inset-0 flex z-40 lg:hidden" @close="mobileFiltersOpen = false">
      <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
                       enter-to="opacity-100" leave="transition-opacity ease-linear duration-300"
                       leave-from="opacity-100" leave-to="opacity-0">
        <DialogOverlay class="fixed inset-0 bg-black bg-opacity-25"/>
      </TransitionChild>

      <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="translate-x-full"
                       enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform"
                       leave-from="translate-x-0" leave-to="translate-x-full">
        <div
            class="ml-auto relative max-w-xs w-full h-full bg-white shadow-xl py-4 pb-12 flex flex-col overflow-y-auto">
          <div class="px-4 flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900">Filters</h2>
            <button type="button"
                    class="-mr-2 w-10 h-10 bg-white p-2 rounded-md flex items-center justify-center text-gray-400"
                    @click="mobileFiltersOpen = false">
              <span class="sr-only">Close menu</span>
              <XIcon class="h-6 w-6" aria-hidden="true"/>
            </button>
          </div>

          <!-- Filters -->
          <form class="mt-4 border-t border-gray-200">
            <h3 class="sr-only">Categories</h3>
            <ul role="list" class="font-medium text-gray-900 px-2 py-3">
              <li v-for="category in subCategories" :key="category.name">
                <a :href="category.href" class="block px-2 py-3">
                  {{ category.name }}
                </a>
              </li>
            </ul>

            <Disclosure as="div" v-for="section in filters" :key="section.id" class="border-t border-gray-200 px-4 py-6"
                        v-slot="{ open }">
              <h3 class="-mx-2 -my-3 flow-root">
                <DisclosureButton
                    class="px-2 py-3 bg-white w-full flex items-center justify-between text-gray-400 hover:text-gray-500">
                      <span class="font-medium text-gray-900">
                        {{ section.name }}
                      </span>
                  <span class="ml-6 flex items-center">
                        <PlusSmIcon v-if="!open" class="h-5 w-5" aria-hidden="true"/>
                        <MinusSmIcon v-else class="h-5 w-5" aria-hidden="true"/>
                      </span>
                </DisclosureButton>
              </h3>
              <DisclosurePanel class="pt-6">
                <div class="space-y-6">
                  <div v-for="(option, optionIdx) in section.options" :key="option.value" class="flex items-center">
                    <input :id="`filter-mobile-${section.id}-${optionIdx}`" :name="`${section.id}[]`"
                           :value="option.value" type="checkbox" :checked="option.checked"
                           class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500"/>
                    <label :for="`filter-mobile-${section.id}-${optionIdx}`" class="ml-3 min-w-0 flex-1 text-gray-500">
                      {{ option.label }}
                    </label>
                  </div>
                </div>
              </DisclosurePanel>
            </Disclosure>
          </form>
        </div>
      </TransitionChild>
    </Dialog>
  </TransitionRoot>
  </div>
</template>

<script>
import {ref} from 'vue'
import {
  Dialog,
  DialogOverlay,
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'

import {XIcon} from '@heroicons/vue/outline'
import {ChevronDownIcon, FilterIcon, MinusSmIcon, PlusSmIcon, ViewGridIcon} from '@heroicons/vue/solid'
const subCategories = [
  {name: 'Totes', href: '#'},
  {name: 'Backpacks', href: '#'},
  {name: 'Travel Bags', href: '#'},
  {name: 'Hip Bags', href: '#'},
  {name: 'Laptop Sleeves', href: '#'},
]
const filters = [
  {
    id: 'color',
    name: 'Color',
    options: [
      {value: 'white', label: 'White', checked: false},
      {value: 'beige', label: 'Beige', checked: false},
      {value: 'blue', label: 'Blue', checked: true},
      {value: 'brown', label: 'Brown', checked: false},
      {value: 'green', label: 'Green', checked: false},
      {value: 'purple', label: 'Purple', checked: false},
    ],
  },
  {
    id: 'category',
    name: 'Category',
    options: [
      {value: 'new-arrivals', label: 'New Arrivals', checked: false},
      {value: 'sale', label: 'Sale', checked: false},
      {value: 'travel', label: 'Travel', checked: true},
      {value: 'organization', label: 'Organization', checked: false},
      {value: 'accessories', label: 'Accessories', checked: false},
    ],
  },
  {
    id: 'size',
    name: 'Size',
    options: [
      {value: '2l', label: '2L', checked: false},
      {value: '6l', label: '6L', checked: false},
      {value: '12l', label: '12L', checked: false},
      {value: '18l', label: '18L', checked: false},
      {value: '20l', label: '20L', checked: false},
      {value: '40l', label: '40L', checked: true},
    ],
  },
]

export default {
  components: {
    Dialog,
    DialogOverlay,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
    ChevronDownIcon,
    FilterIcon,
    MinusSmIcon,
    PlusSmIcon,
    ViewGridIcon,
    XIcon,
  },
  setup() {
    const mobileFiltersOpen = ref(false)

    return {
      subCategories,
      filters,
      mobileFiltersOpen,
    }
  },
}
</script>