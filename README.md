JAGA
==============
*JAGATAKUN FIGHTS FOR THE USER*

**LICENSE**
 - JAGA's codebase powers [jaga.io](http://jaga.io/) and is available for use on your domain under the copyleft [GNU Affero General Public License](license.txt).
 - Licensing JAGA under the AGPL was intended to encourage participation in the project and assure that the code remains non-commercial and non-proprietary.
 - The AGPL allows anyone to use the code while mandating that, where the code is redistributed or run on a network, any modifications to the code must be shared.
 - If this applies to you or your project, we request that you make your code available via a public GitHub repository.
 - Please also consider submitting pull requests for inclusion in the master. JOIN TEAM JAGA.
 
**FEATURES**
- INDEX
    - main domain: aggregate site showing recent posts from all **channels and categories**.
	- subdomain: shows channel-specific recent posts 
- HOME 
    - personalized; only available when logged in
    - shows posts from channels that the user is subscribed to
- CHANNELS
    - users can **create channels**: `<channel>.jaga.io`
    - a **theme** must be selected for the channel.
    - at least one **category** must be assigned to the channel: `<channel>.jaga.io/k/<category>/`
- CATEGORIES
    - users can select existing categories for their channels, or create new ones
- POSTS
    - posts exists in `jaga.io/k/`
    - users can **post** to any channel and any category on JAGA: `<channel>.jaga.io/k/<category>/<post/>`
    - posts can include **images** and an **outbound link**.
    - posts can be marked as **events**; date & time can be set.
    - posts can have **geographic coordinates**; latitude and longitude can be set.
    - posts can be edited and deleted by OP.
- COMMENTS
    - users can **comment** on any post in any category on any channel.
    - plaintext only and observe line breaks.
    - comments can be deleted.
- USERS
    - have individual profiles: `jaga.io/u/<username>/`
    - can subscribe to channels; this personalizes HOME
- MESSAGING
    - users can send each other private messages `jaga.io/imo/`