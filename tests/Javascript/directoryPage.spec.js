import { createLocalVue, shallowMount } from '@vue/test-utils'
import DirectoryPage from '../../resources/js/guests/DirectoryPage.vue'
import Vue2Filters from 'vue2-filters'
import BootstrapVue from 'bootstrap-vue'

const localVue = createLocalVue()

localVue.use(Vue2Filters)
localVue.use(BootstrapVue)

describe('DirectoryPage.vue', () => {
  let wrapper;

  beforeEach(() => {
    wrapper = shallowMount(DirectoryPage, {
      localVue,
      data () {
        return {
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
        }
      }
    });
  });

  it('Check that search box is displayed.', () => {
    expect(wrapper.find('#search')).toBeTruthy()
  })

  it('Listings are displayed when present.', async () => {
    wrapper.setData({search: 'kula'})
    await wrapper.vm.$nextTick()
    const textInput = wrapper.find('.listings')
    expect(textInput.exists()).toBe(true)
  })

  it('Data can be set on search.', () => {
    wrapper.setData({search: 'Test search!'})
    expect(wrapper.vm.$data.search).toBe('Test search!')
  })

  it('Search text is displayed with no results.', async () => {
    wrapper.setData({search: 'Test search!'})
    await wrapper.vm.$nextTick()
    const search = wrapper.find('.card-title')
    expect(search.text()).toBe('Search term "Test search!" returned no results!')
  })

  it('Search result is valid and returns listings', async () => {
    wrapper.setData({search: 'Kula'})
    await wrapper.vm.$nextTick()
    const search = wrapper.find('h4')
    expect(search.text()).toBe("The Essential Studio Manager")
  })

  it('getListings method returns listings.', () => {
    //
  })
})
 