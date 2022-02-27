<template>
  <div
    class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
  >
    <div class="flex-1 flex justify-between sm:hidden">
      <a
        href="#"
        @click="onClickPreviousPage"
        :class="[
          currentPage === 1
            ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
            : 'hover:bg-gray-50',
        ]"
        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white"
      >
        Previous
      </a>
      <a
        href="#"
        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
      >
        Next
      </a>
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Showing
          <span class="font-medium"> 1 </span>
          to
          <span class="font-medium"> 10 </span>
          of
          <span class="font-medium">
            {{ total }}
          </span>
          results
        </p>
      </div>
      <div>
        <nav
          class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
          aria-label="Pagination"
        >
          <a
            href="#"
            :class="[
              currentPage === 1
                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                : 'hover:bg-gray-50',
            ]"
            @click="onClickPreviousPage"
            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500"
          >
            <span class="sr-only">Previous</span>
            <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
          </a>
          <template v-for="page in pages" :key="page.name">
            <a
              :class="[
                page.isDisabled
                  ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                  : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
              ]"
              href="#"
              aria-current="page"
              class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
              @click="onClickPage(page.name)"
            >
              {{ page.name }}
            </a>
          </template>
          <a
            href="#"
            @click="onClickNextPage"
            :class="[currentPage === lastPage ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'hover:bg-gray-50']"
            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500"
          >
            <span class="sr-only">Next</span>
            <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
          </a>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/solid";

export default {
  props: {
    total: {
      type: Number,
      default: 0,
    },
    perPage: {
      type: Number,
      default: 0,
    },
    lastPage: {
      type: Number,
      default: 0,
    },
    maxVisibleButtons: {
      type: Number,
      default: 10,
    },
    currentPage: {
      type: Number,
      default: 0,
    },
  },
  components: {
    ChevronLeftIcon,
    ChevronRightIcon,
  },
  computed: {
    totalPages() {
      return this.total / this.perPage;
    },
    startPage() {
      if (this.currentPage === 1) {
        return 1;
      }

      // When on the last page
      if (this.currentPage === this.totalPages) {
        return this.totalPages - this.maxVisibleButtons;
      }

      // When inbetween
      return this.currentPage - 1;
    },
    pages() {
      const range = [];

      for (
        let i = this.startPage;
        i <= Math.min(this.startPage + this.maxVisibleButtons - 1, this.totalPages);
        i++
      ) {
        range.push({
          name: i,
          isDisabled: i === this.currentPage,
        });
      }

      return range;
    },
  },
  methods: {
    onClickPreviousPage() {
      this.$emit("page-changed", this.currentPage - 1);
    },
    onClickPage(page) {
      this.$emit("page-changed", page);
    },
    onClickNextPage() {
      this.$emit("page-changed", this.currentPage + 1);
    },
  },
};
</script>
