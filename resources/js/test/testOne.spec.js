import { createLocalVue, shallowMount } from '@vue/test-utils'
import DirectoryPage from '../pages/DirectoryPage.vue'
import { BootstrapVue } from 'bootstrap-vue'

const localVue = createLocalVue()

localVue.use(BootstrapVue)

describe('DirectoryPage.vue', function() {
  it('Checking if card exists', function() {
    const wrapper = shallowMount(DirectoryPage, {
      localVue
    })
    const card = wrapper.find('.card')
    expect(card).toBeTruthy()
  })
})

describe('DirectoryPage.vue', function() {
  it('Checking if card exists', function() {
    const wrapper = shallowMount(DirectoryPage, {
      localVue
    })
    const col = wrapper.find('.col-md-10')
    expect(col).toBeTruthy()
  })
})

 