import { createLocalVue, shallowMount } from '@vue/test-utils'
import ListingPage from '../../resources/js/users/pages/ListingsPage.vue'
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
      data () {
        return {
          user: {},
          listings: [],
          listing: {}
        }
      }
    });
  });
  
  it('No results listing card is displayed.', () => {
    const h5 = wrapper.find('h5')
    const cardText = wrapper.find('.card-text')
    const createListingButton = wrapper.find('#createListingButton')
    expect(createListingButton.exists()).toBe(true)
    expect(cardText.text()).toBe('To get started click the button below and create your first listing.')
    expect(h5.text()).toBe('You don\'t have any listings')
  })

  it('Listings are displayed when present.', async () => {
    wrapper.setData({
      listings: [
        {
          id: 1,
          user_id: 1,
          name: "Jonathon Ringeisen",
          business_name: "The Essential Studio Manager",
          city: "Kula",
          state: "HI",
          description: "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.",
          avatar: "https://esm-directory.s3.us-west-1.amazonaws.com/avatars/1_1586409175.png",
          starting_package: 1200,
          created_at: "2020-04-09T05:12:56.000000Z",
          updated_at: "2020-04-09T05:12:56.000000Z",
          packages: []
        }
      ],
    })

    await wrapper.vm.$nextTick()

    const table = wrapper.find('.table')
    expect(table.isVisible()).toBe(true)
  })

  it('Table actions menu exists.', async () => {
    wrapper.setData({
      listings: [
        {
          id: 1,
          user_id: 1,
          name: "Jonathon Ringeisen",
          business_name: "The Essential Studio Manager",
          city: "Kula",
          state: "HI",
          description: "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.",
          avatar: "https://esm-directory.s3.us-west-1.amazonaws.com/avatars/1_1586409175.png",
          starting_package: 1200,
          created_at: "2020-04-09T05:12:56.000000Z",
          updated_at: "2020-04-09T05:12:56.000000Z",
          packages: []
        }
      ],
    })

    await wrapper.vm.$nextTick()

    const buttonWrapper = wrapper.find('#dropdown-1')
    expect(buttonWrapper.isVisible()).toBe(true)
  })
})
