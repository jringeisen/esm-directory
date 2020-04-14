import { createLocalVue, shallowMount } from '@vue/test-utils'
import ListingPage from '../pages/ListingsPage.vue'
import Vue2Filters from 'vue2-filters'
import BootstrapVue from 'bootstrap-vue'

const localVue = createLocalVue()

localVue.use(Vue2Filters)
localVue.use(BootstrapVue)

describe('ListingPage.vue', () => {
  let wrapper;
  
  beforeEach(() => {
    wrapper = shallowMount(ListingPage, {
      localVue,
    });
  });
  
  it('No listings card is displayed.', () => {
    const h5 = wrapper.find('h5')
    const cardText = wrapper.find('.card-text')
    const createListingButton = wrapper.find('#createListingButton')
    expect(createListingButton.exists()).toBe(true)
    expect(cardText.text()).toBe('To get started click the button below and create your first listing.')
    expect(h5.text()).toBe('You don\'t have any listings')
  })
})