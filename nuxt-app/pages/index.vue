<template>
  <Layout />
</template>

<script>
export default {
  mounted () {
    const bodyElement = document.querySelector('body')
    bodyElement.classList.add('h-full')
    bodyElement.classList.add('bg-black')
  }
}
</script>
