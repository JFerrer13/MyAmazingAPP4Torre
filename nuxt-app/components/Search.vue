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
        <div class="bg-gray-800 pb-3">
          <div class="px-2 pt-2">
            <div class="flex">
              <div class="px-2 pt-2">
                <button type="button" class="bg-gray-800 flex text-sm rounded-full outline-none ring-4 ring-offset-1 ring-offset-gray-800 ring-gray-500" aria-expanded="false" aria-haspopup="true" @click="openTorre()">
                  <img class="img-adj rounded-full" src="https://res.cloudinary.com/torre-technologies-co/image/upload/v1632894958/origin/starrgate/users/profile_367bbd81421681c9dc2fb3dcb9fe428d11c08e43.jpg" alt="">
                </button>
              </div>
              <div class="ml-3">
                <a class="text-green text-xl" v-text="'Este es el nombre'" />
                <p class="text-gray-300" v-text="'Este es su cargo, por llamarlo de alguna manera'" />
                <p class="text-gray-300 text-sm" v-text="'Y su lugar de residencia'" />
              </div>
            </div>
          </div>
          <div class="m-3 mb-0 text-right">
            <button class="bg-green text-gray px-6 py-2 uppercase rounded-full border-2 border-gray font-bold" @click="getPeople()">
              <i class="fas fa-dna mr-2" />
              genome
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data: () => ({
    data: null
  }),
  methods: {
    async getPeople (user) {
      const params = {
        lang: 'es',
        size: 20,
        aggregate: false,
        offset: 14
      }
      const data = await this.$axios.$post('https://search.torre.co/people/_search', params)
      this.data = data
    }
  }
}
</script>
