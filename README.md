JAGA
==============
*JAGATAKUN FIGHTS FOR THE USER*

**LICENSE**
 - The JAGA codebase is available for use under the copyleft [GNU Affero General Public License](license.txt).
 - Licensing JAGA under the AGPL was intended to encourage participation in the JAGA project and assure that the code remains non-commercial and non-proprietary.
 - Generally speaking, the AGPL allows anyone to use this code while mandating that any modifications to it are shared if the code is redistributed or run on a network.
 - If this applies to you or your project, we request that you make your codebase available via a public GitHub repository.
 - Please also consider submitting pull requests for inclusion in the master. JOIN TEAM JAGA.
 
**FEATURES**
- INDEX
    - main domain: aggregate site showing recent content from all **channels and categories**.
	- subdomain: shows channel-specific content recent content 
- HOME 
    - personalized; only available when logged in
    - shows content from channels that the user is subscribed to
- CHANNELS
    - users can **create channels**: `<channel>.jaga.io`
    - a **theme** must be selected for the channel.
    - at least one **category** must be assigned to the channel: `<channel>.jaga.io/k/<category>/`
- CATEGORIES
    - users can select existing categories for their channels, or create new ones
- POSTS
    - content exists in `jaga.io/k/`
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