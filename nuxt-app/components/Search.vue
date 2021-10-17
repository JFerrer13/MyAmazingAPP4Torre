<template>
  <section class="py-10">
    <div class="max-w-3xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="flex">
        <Search-cbo caption="Search people by name" @search="setSrchTern($event)" />
      </div>
      <div class="mt-10">
        <div v-if="loading" class="text-gray-400 text-xl text-center">
          <i class="fas fa-circle-notch animate-spin" />
        </div>
        <!--the search cards -->
        <div v-else-if="people.length">
          <div v-for="(item,index) in people" :key="index" class="bg-gray-800 pb-3 my-3">
            <div class="px-2 pt-2">
              <div class="flex">
                <div class="px-2 pt-2">
                  <button type="button" class="bg-gray-800 flex text-sm rounded-full outline-none ring-4 ring-offset-1 ring-offset-gray-800 ring-gray-500 focus:ring-white" aria-expanded="false" aria-haspopup="true" @click="displayGenome(item.username)">
                    <img class="img-adj rounded-full" :src="item.picture" alt="">
                  </button>
                </div>
                <div class="w-9/12 md:w-10/12 ml-3">
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
        <div v-else class="bg-gray-800 my-3 px-10 py-16">
          <h2 class="text-green text-3xl text-center">
            Welcome
          </h2>
          <p class="text-gray-300 py-3">
            The App searches people using the API endpoints provided. Then it displays the profile information about the chosen user. While you are interacting with the genome we are tracking the mouse position. With the information collected it's been built the heatmap of usage. Hope you enjoy it!. If you have any question please email me <a href="mailto:13ferrer@gmial.com" class="text-green hover:text-gray-500 cursor-pointer">13ferrer@gmail.com</a>
          </p>
          <p class="text-gray-300 py-3">
            Click on <span class="text-green">About</span> to read the fool documentation.
          </p>
          <p class="text-gray-300 py-3">
            Choose the <span class="text-green">Search</span> option to return to this page to search people again.
          </p>
          <p class="text-gray-300 py-3">
            Click on <span class="text-green">Data</span> to check out the heatmap of the genome page usage.
          </p>
        </div>
      </div>
      <div v-if="data && !loading" class="my-5 text-center">
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
import SearchCbo from './Search-cbo.vue'
export default {
  components: { SearchCbo },
  data: () => ({
    serverUrl: process.env.serverUrl,
    data: null,
    srchTern: '',
    size: 20,
    loading: false
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
    setSrchTern (tern) {
      this.srchTern = tern
      this.getPeople()
    },
    async getPeople (before, after) {
      if (!this.loading) {
        let params = null
        let parameters = ''
        const paramsUrl = {
          lang: 'en',
          size: this.size,
          aggregate: false,
          before,
          after
        }
        this.loading = true
        for (const key in paramsUrl) {
          if (paramsUrl[key] !== null && paramsUrl[key] !== undefined) {
            parameters += `&${key}=${paramsUrl[key]}`
          }
        }
        if (this.srchTern) {
          params = {
            name: this.srchTern
          }
        }
        parameters = parameters.substring(1, parameters.length)
        const data = await this.$axios.$post(`${this.serverUrl}/searchPeopleFromTorre/${parameters}`, params).catch(() => {
          this.pushAlert({
            title: 'Ups!',
            text: 'Seems like the server is not responding. Please refresh the page.',
            color: 'yellow'
          })
        })
        this.data = data
        this.loading = false
      }
    },
    displayGenome (username) {
      this.$emit('sendUsername', username)
    },
    pushAlert (element) {
      this.$emit('newalert', element)
    }
  }
}
</script>
