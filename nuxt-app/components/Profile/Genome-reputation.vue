<template>
  <div>
    <div class="w-full px-5 pt-5">
      <div class="grid grid-cols-4">
        <div class="text-center">
          <div class="block text-lg text-gray-400">
            <i class="fas fa-eye" />
          </div>
          <div class="block text-3xl">
            150k
          </div>
          <p class="text-xs font-sm text-gray-400">
            views
          </p>
        </div>
        <div class="text-center">
          <div class="block text-lg text-gray-400">
            <i class="fas fa-user-check" />
          </div>
          <div class="block text-3xl">
            80k
          </div>
          <p class="text-xs font-sm text-gray-400">
            signalers
          </p>
        </div>
        <div class="text-center">
          <div class="block text-lg text-gray-400">
            <i class="fas fa-users" />
          </div>
          <div class="block text-3xl">
            100k
          </div>
          <p class="text-xs font-sm text-gray-400">
            connections
          </p>
        </div>
        <div class="text-center">
          <div class="block text-lg text-gray-400">
            <i class="fas fa-weight-hanging" />
          </div>
          <div class="block text-3xl">
            100k
          </div>
          <p class="text-xs font-sm text-gray-400">
            recommendation weight
          </p>
        </div>
      </div>
    </div>
    <div class="w-full border-t border-gray-600 p-5 mt-5">
      <div class="grid grid-cols-2">
        <h3 class="text-xl">
          Signals
        </h3>
        <div class="text-right">
          <a class="relative inline-flex items-center px-3 py-2 rounded-full text-sm font-medium text-green hover:bg-gray-700 shadow-lg cursor-pointer">
            <i class="fas fa-share-alt text-2xl" />
          </a>
        </div>
      </div>
      <div class="flex flex-wrap justify-center text-center mb-10">
        <p class="px-5 pb-10 w-full">
          Let's <span v-text="user.person.name.split(' ')[0]" /> know you may consider working together:
        </p>
        <a class="cursor-pointer">
          <span class="p-3 pl-5 uppercase text-green font-sm bg-gray-700 shadow-lg rounded-l-full text-base">signaled</span>
          <span class="p-3 pr-5 uppercase text-green font-sm bg-gray-700 shadow-lg rounded-r-full text-base">
            <i class="far fa-bell" />
          </span>
        </a>
      </div>
      <div class="grid grid-cols-2">
        <div class="text-center">
          <div class="block text-3xl">
            <i class="fas fa-user-check" />
            <span class="text-green"> 100,500</span>
          </div>
          <p class="text-sm font-sm">
            people signaled <span v-text="user.person.name.split(' ')[0]" />
          </p>
        </div>
        <div class="text-center">
          <div class="block text-3xl">
            <i class="fas fa-user-check" />
            <span class="text-green"> 500</span>
          </div>
          <p class="text-sm font-sm">
            people signaled by <span v-text="user.person.name.split(' ')[0]" />
          </p>
        </div>
      </div>
    </div>
    <div class="w-full border-t border-gray-600">
      <div class="text-center mb-5">
        <div class="text-left p-5">
          <h3 class="text-xl">
            Community
          </h3>
        </div>
        <div class="flex flex-wrap justify-center">
          <p class="text-3xl w-full">
            92,209
          </p>
          <p class="text-sm font-sm px-10 text-gray-400 w-6/12 mx-auto">
            friends/colleagues connected
          </p>
        </div>
      </div>
    </div>
    <div class="w-full border-t border-gray-600 p-5">
      <div class="text-center mb-5">
        <p class="text-green text-xl">
          Time is over
        </p>
        <p class="px-5 pb-10">
          I need to stop investing time on the frontend. Hoping it's good enough. It's just about time, the more the merrier.
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      default: null
    }
  }
}
</script>
