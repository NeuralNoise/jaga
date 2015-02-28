JAGA
==============

*JAGATAKUN FIGHTS FOR THE USER*

**LICENSE**
- *This code powers [JAGA.IO](http://jaga.io/) and is freely available for use under the copyleft [GNU Affero General Public License](http://www.gnu.org/licenses/agpl-3.0.html). This license allows anyone to use or modify this code, but requires that any modifications to it used on a network must be shared and is intended to encourage participation in the project and assure that the code remains non-commercial and non-proprietary. ([license.txt](license.txt))

**FEATURES**
- INDEX
    - main domain: aggregate site showing recent content from all **channels and categories**.
	- subdomain: shows channel-specific content recent content 
- HOME 
    - available when logged in
    - shows content from channels that the user is subscribed to
- CHANNELS
    - users can **create channels**: `<channel>.jaga.io`
    - a **theme** must be selected for the channel.
    - at least one **category** must be assigned to the channel: `<channel>.jaga.io/k/<category>/`
- CATEGORIES
    - users can select existing categories for their channels, or create new ones
- POSTS
    - content exists in `jaga.io/k/`
    - users can **post** to any channel and any category on The Kutchannel: `<channel>.jaga.io/k/<category>/<post/>`
    - posts can include **images** and an **outbound link**.
    - posts can be marked as **events**; date & time can be set.
    - posts can have **geographic coordinates**; latitude and longitude can be set.
    - posts can be edited and deleted by OP.
- COMMENTS
    - users can **comment** on any post in any category on any channel.
    - plaintext only and observe line breaks.
    - comments can be deleted.
- USERS
    - individual profiles as `jaga.io/u/<username>/`
    - can subscribe to channels; this personalizes HOME
- MESSAGING
    - users can send each other private messages `jaga.io/imo/`