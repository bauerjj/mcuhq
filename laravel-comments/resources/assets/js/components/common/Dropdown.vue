<template>
  <div class="dropdown">
    <button @click="toggle" class="dropdown-toggle btn btn-link p-0">
      <slot name="toggle"></slot>
    </button>

    <div class="dropdown-menu py-1">
      <slot name="items"></slot>
    </div>
  </div>
</template>

<script>
document.addEventListener('click', e => {
  [...document.querySelectorAll('.dropdown')].forEach(el => {
    if ([...el.classList].includes('show')) {
      el.classList.remove('show')
    }
  })
})

export default {
  name: 'dropdown',

  methods: {
    toggle () {
      setTimeout(() => {
        this.$el.classList.toggle('show')
      }, 0)
    }
  }
}
</script>
