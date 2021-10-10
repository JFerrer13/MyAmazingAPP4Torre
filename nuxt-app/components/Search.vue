<template>
  <section class="py-10">
    <div class="max-w-3xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2">
        <div class="">
          <h2 class="text-white">
            Our first step it's to retrieves data
          </h2>
        </div>
        <div class="text-right">
          <button class="bg-green text-gray px-6 py-2 uppercase rounded-full border-2 border-gray font-bold" @click="getPeople()">
            <i class="fas fa-database mr-2" />
            Get data
          </button>
        </div>
      </div>
      <div class="mt-10">
        <!--the search cards -->
        <div v-for="(item,index) in people" :key="index" class="bg-gray-800 pb-3 my-3">
          <div class="px-2 pt-2">
            <div class="flex">
              <div class="px-2 pt-2">
                <button type="button" class="bg-gray-800 flex text-sm rounded-full outline-none ring-4 ring-offset-1 ring-offset-gray-800 ring-gray-500 focus:ring-white" aria-expanded="false" aria-haspopup="true" @click="displayGenome(item.username)">
                  <img class="img-adj rounded-full" :src="item.picture" alt="">
                </button>
              </div>
              <div class="w-10/12 ml-3">
                <a class="text-green text-xl" v-text="item.name" />
                <p class="text-gray-300 truncate" v-text="item.professionalHeadline" />
                <p class="text-gray-300 text-sm" v-text="item.locationName" />
              </div>
            </div>
          </div>
          <div class="m-3 mb-0 text-right">
            <button class="bg-green text-gray px-6 py-2 uppercase rounded-full border-2 border-gray font-bold shadow-md" @click="displayGenome(item.username)">
              <i class="fas fa-dna mr-2" />
              genome
            </button>
          </div>
        </div>
      </div>
      <div v-if="data" class="my-5 text-center">
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
          <a v-if="data.pagination.previous" href="#" class="relative inline-flex items-center px-2 py-2 rounded-full hover:bg-gray-800 text-sm font-medium text-green hover:bg-gray-50" @click="getPeople(data.pagination.previous, null)">
            <span class="sr-only">Previous</span>
            <!-- Heroicon name: solid/chevron-left -->
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
          </a>
          <p class="text-gray-400 p-2">
            <span v-text="data.offset + 1" />
            - <span v-text="data.offset + data.size" />
            of approximately <span v-text="Math.trunc(data.total/data.size)" />
          </p>
          <a v-if="data.pagination.next" href="#" class="relative inline-flex items-center px-2 py-2 rounded-full hover:bg-gray-800 text-sm font-medium text-green hover:bg-gray-50" @click="getPeople(null, data.pagination.next)">
            <span class="sr-only">Next</span>
            <!-- Heroicon name: solid/chevron-right -->
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
          </a>
        </nav>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data: () => ({
    data: null,
    size: 20
  }),
  computed: {
    people () {
      if (this.data) {
        return this.data.results
      } else {
        return []
      }
    },
    pagees () {
      if (this.data) {
        return 2
      } else {
        return 1
      }
    }
  },
  mounted () {
    const bodyElement = document.querySelector('body')
    bodyElement.classList.remove('bg-gray-800')
    bodyElement.classList.add('bg-black')
  },
  methods: {
    async getPeople (before, after) {
      const params = {
        lang: 'en',
        size: this.size,
        aggregate: false,
        before,
        after
      }
      let parameters = ''
      for (const key in params) {
        if (params[key] !== null && params[key] !== undefined) {
          parameters += `&${key}=${params[key]}`
        }
      }
      parameters = parameters.substring(1, parameters.length)
      const data = await this.$axios.$post(`https://search.torre.co/people/_search?${parameters}`)
      this.data = data
    },
    displayGenome (username) {
      this.$emit('sendUsername', username)
    }
  }
}
</script>
