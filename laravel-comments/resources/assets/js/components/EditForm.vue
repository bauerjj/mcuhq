<template>
  <form @submit.prevent="save" @keydown="form.errors.clear($event.target.name)" class="comment__edit-form">
    <div class="form-group" :class="{ 'has-danger': form.errors.has('content') }">
      <editor v-model="form.content" @submit="save"></editor>
      <has-error :form="form" field="content"></has-error>
    </div>

    <div v-if="comment.edit_url" class="mb-2">
      <a :href="comment.edit_url">{{ $t('advance_edit') }}</a>
    </div>

    <div class="form-group clearfix">
      <button type="submit" class="btn btn-success" :disabled="form.busy || form.content.length === 0">
        {{ $t('update_button') }}
      </button>

      <button type="button" class="btn btn-secondary" @click="close">
        {{ $t('cancel_button') }}
      </button>
    </div>
  </form>
</template>

<script>
import Form from 'vform'

export default {
  props: ['comment'],

  components: {
    editor: require('./Editor.vue')
  },

  data: () => ({
    form: new Form({
      content: ''
    })
  }),

  created () {
    this.form.content = this.comment.content
  },

  methods: {
    save () {
      this.form.patch(`/comments/${this.comment.id}`)
        .then(this.onSuccess)
        .catch(this.onError)
    },

    onSuccess ({ data }) {
      this.$store.commit('UPDATE_COMMENT', { data, comment: this.comment })

      this.$nextTick(() => this.$parent.closeEdit(data))
    },

    onError ({ response: { status }}) {
      if (status === 403) {
        this.$store.commit('UPDATE_COMMENT', {
          comment: this.comment,
          data: { can_update: false }
        })
        this.form.errors.set({ content: this.$t('error_edit') })
      } else if ([401, 404, 500].includes(status)) {
        this.form.errors.set({ content: this.$t(`error_${status}`) })
      }
    },

    close () {
      this.$parent.closeEdit()
    }
  }
}
</script>
