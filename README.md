The Kutchannel
==============

*JAGATAKUN FIGHTS FOR THE USER*

**LICENSE**
- *This code powers [The Kutchannel](http://the.kutchannel.net) and is freely available for use under the [GNU Affero General Public License](http://www.gnu.org/licenses/agpl-3.0.html) (see license.md; [FAQ](http://www.affero.org/oagf.html)).*

**PRODUCTION DEPLOYMENT**
- The master branch is actively deployed on all subdomains of The Kutchannel (`*.kutchannel.net`) except http://niseko.kutchannel.net which, pending migration, is still using the old code. Devs... please edit your host files to reflect this.

**FEATURES**
- HOME SUBDOMAIN (eg: [THE.KUTCHANNEL.NET](http://the.kutchannel.net))
    - aggregate site showing recent content from all **channels and categories**.
- JAGAROLL
    - shows content from channels (...categories,users?) the owner is subscribed to
- CHANNEL
    - users can **create channels**: `<channel>.kutchannel.net`
    - a **theme** must be selected for the channel.
    - at least one **category** must be assigned to the channel: `<channel>.kutchannel.net/k/<category>/`
- CATEGORIES
    - users can select existing categories for their channels, or create new ones
- POSTS
    - content exists in `/k/`
    - users can **post** to any channel and any category on The Kutchannel: `<channel>.kutchannel.net/k/<category>/<post/>`
    - posts can include **images** and an **outbound link**.
    - posts can be marked as **events**; date & time can be set.
    - posts can have **geographic coordinates**; latitude and longitude can be set.
    - posts can be edited and deleted by OP.
- COMMENTS
    - users can **comment** on any post in any category on any channel.
    - plaintext only and observe line breaks.
    - comments can be edited and deleted.
- USERS
    - individual profiles as `/u/<username>/`
    - can subscribe to channels, categories (TBD), or users (TBD); this personalizes newsfeed