# ONYXA Private Limited Laravel Website Testing Checklist

| Test case ID | Module | Test action | Expected result | Status |
|---|---|---|---|---|
| TC-001 | Public Pages | Open Home page `/` | Home page loads without error and shows featured sections | Pending |
| TC-002 | Public Pages | Open About page `/about-us` | About content displays correctly | Pending |
| TC-003 | Public Pages | Open Sustainability page `/sustainability` | Sustainability content displays correctly | Pending |
| TC-004 | Products | Open `/products` | Active/published products display with pagination | Pending |
| TC-005 | Products | Search product by name | Matching products display and query is preserved in pagination | Pending |
| TC-006 | Products | Filter products by category | Only selected category products display | Pending |
| TC-007 | Products | Filter products by availability | Only matching availability products display | Pending |
| TC-008 | Product Details | Open `/products/{slug}` | Product details, images, related products, and WhatsApp button display | Pending |
| TC-009 | News | Open `/news` | Published news posts display | Pending |
| TC-010 | News | Search news by title | Matching news posts display | Pending |
| TC-011 | News | Sort news latest/oldest | News order changes correctly | Pending |
| TC-012 | News Details | Open `/news/{slug}` | Full news content and related/latest news display | Pending |
| TC-013 | Events | Open `/events` | Upcoming and completed events display | Pending |
| TC-014 | Events | Filter upcoming events | Only upcoming events display | Pending |
| TC-015 | Events | Filter completed events | Only completed events display | Pending |
| TC-016 | Event Details | Open `/events/{slug}` | Event details, date, time, location, and status display | Pending |
| TC-017 | Gallery | Open `/gallery` | Active gallery images display in a responsive grid | Pending |
| TC-018 | Gallery | Filter gallery by category | Only selected category images display | Pending |
| TC-019 | Gallery | Click gallery image | Lightbox opens and closes correctly | Pending |
| TC-020 | Contact Form | Submit valid contact form | Message saves and success message displays | Pending |
| TC-021 | Contact Form | Submit empty required fields | Validation errors display | Pending |
| TC-022 | Contact Form | Submit invalid email or phone | Validation errors display | Pending |
| TC-023 | WhatsApp | Click product WhatsApp button | WhatsApp opens with pre-filled product inquiry | Pending |
| TC-024 | WhatsApp | Click contact WhatsApp button | WhatsApp opens with pre-filled company inquiry | Pending |
| TC-025 | Admin Login | Open `/admin/login` | Login page loads with ONYXA branding | Pending |
| TC-026 | Admin Login | Login with valid admin credentials | Redirects to admin dashboard | Pending |
| TC-027 | Admin Login | Login with invalid credentials | Error message displays | Pending |
| TC-028 | Admin Security | Access `/admin` while logged out | Redirects to admin login | Pending |
| TC-029 | Admin Security | Access admin route as non-admin | Redirects to homepage | Pending |
| TC-030 | Admin Dashboard | Open dashboard | Product, news, event, gallery, and message counts display | Pending |
| TC-031 | Admin Dashboard | Check recent dashboard sections | Latest news, upcoming events, and recent messages display | Pending |
| TC-032 | Product CRUD | Create product with valid data | Product saves with generated slug | Pending |
| TC-033 | Product CRUD | Upload product main image | Image stores in `storage/app/public/products` and displays | Pending |
| TC-034 | Product CRUD | Upload additional images | Multiple product images save and display | Pending |
| TC-035 | Product CRUD | Edit product details | Product updates successfully | Pending |
| TC-036 | Product CRUD | Replace product image | Old image is deleted and new image displays | Pending |
| TC-037 | Product CRUD | Delete product | Product and related image files are removed | Pending |
| TC-038 | Product Status | Publish or inactivate product | Status changes and badge updates | Pending |
| TC-039 | Category CRUD | Create product category | Category saves with generated slug | Pending |
| TC-040 | Category CRUD | Upload category image | Image stores and displays in admin table | Pending |
| TC-041 | Category CRUD | Edit category | Category updates successfully | Pending |
| TC-042 | Category CRUD | Delete category with products | Delete is blocked with error message | Pending |
| TC-043 | Category CRUD | Delete empty category | Category deletes successfully | Pending |
| TC-044 | Category Status | Activate or inactivate category | Status changes and badge updates | Pending |
| TC-045 | News CRUD | Create draft news | News saves as draft | Pending |
| TC-046 | News CRUD | Publish news | News appears on public news page | Pending |
| TC-047 | News CRUD | Upload featured image | Image stores in `storage/app/public/news` and displays | Pending |
| TC-048 | News CRUD | Edit news | News updates successfully | Pending |
| TC-049 | News CRUD | Delete news | News and featured image are removed | Pending |
| TC-050 | News Status | Publish or unpublish news | Status changes and badge updates | Pending |
| TC-051 | Event CRUD | Create upcoming event | Event saves and appears on public events page | Pending |
| TC-052 | Event CRUD | Create completed event | Event appears under completed events | Pending |
| TC-053 | Event CRUD | Upload event image | Image stores in `storage/app/public/events` and displays | Pending |
| TC-054 | Event CRUD | Edit event | Event updates successfully | Pending |
| TC-055 | Event CRUD | Delete event | Event and image are removed | Pending |
| TC-056 | Event Status | Mark event completed or cancelled | Status changes and badge updates | Pending |
| TC-057 | Gallery Category CRUD | Create gallery category | Category saves with slug | Pending |
| TC-058 | Gallery Category CRUD | Edit gallery category | Category updates successfully | Pending |
| TC-059 | Gallery Category CRUD | Delete category with images | Delete is blocked | Pending |
| TC-060 | Gallery CRUD | Upload gallery image | Image stores in `storage/app/public/gallery` and displays | Pending |
| TC-061 | Gallery CRUD | Edit gallery image | Title, category, description, and status update | Pending |
| TC-062 | Gallery CRUD | Replace gallery image | Old image is deleted and new image displays | Pending |
| TC-063 | Gallery CRUD | Delete gallery image | Record and image file are removed | Pending |
| TC-064 | Gallery Status | Activate or inactivate gallery image | Status changes and badge updates | Pending |
| TC-065 | Contact Messages | Open messages list | Messages display with pagination | Pending |
| TC-066 | Contact Messages | Search by name, email, or subject | Matching messages display | Pending |
| TC-067 | Contact Messages | Filter unread/read | Correct message status list displays | Pending |
| TC-068 | Contact Messages | View message details | Message detail page opens | Pending |
| TC-069 | Contact Messages | Mark message read or unread | Status changes and badge updates | Pending |
| TC-070 | Contact Messages | Delete message | Message is removed | Pending |
| TC-071 | Page Editing | Edit About page section | Public About page displays updated content | Pending |
| TC-072 | Page Editing | Edit Vision/Mission sections | Public About page displays updated values | Pending |
| TC-073 | Page Editing | Edit Sustainability section | Public Sustainability page displays updated content | Pending |
| TC-074 | Page Editing | Upload page section image | Image stores and displays where used | Pending |
| TC-075 | Settings | Update company name and tagline | Navbar/footer reflect updated values | Pending |
| TC-076 | Settings | Upload logo | Logo stores in `storage/app/public/settings` and displays | Pending |
| TC-077 | Settings | Upload favicon | Favicon displays in browser tab | Pending |
| TC-078 | Settings | Update contact details | Footer/contact page reflect updated values | Pending |
| TC-079 | Settings | Update social links | Footer social buttons use updated URLs | Pending |
| TC-080 | Image Uploads | Upload invalid file type | Validation error displays | Pending |
| TC-081 | Image Uploads | Upload oversized image | Validation error displays | Pending |
| TC-082 | Image Uploads | Check `/storage/...` URLs | Uploaded images are publicly accessible | Pending |
| TC-083 | Mobile Responsiveness | Test public navbar on mobile | Menu opens/closes and links work | Pending |
| TC-084 | Mobile Responsiveness | Test product, news, event, and gallery grids | Cards stack cleanly without overflow | Pending |
| TC-085 | Mobile Responsiveness | Test contact form on mobile | Inputs stack and remain usable | Pending |
| TC-086 | Mobile Responsiveness | Test admin sidebar on mobile | Sidebar toggle and overlay work | Pending |
| TC-087 | Admin Tables | Test admin tables on mobile | Tables scroll horizontally without layout break | Pending |
| TC-088 | Security | Submit forms without CSRF token | Request is rejected | Pending |
| TC-089 | Security | Try script tags in forms | Validation blocks unsafe input | Pending |
| TC-090 | Security | Try unauthorized admin status update | Request is blocked or redirected | Pending |
| TC-091 | Security | Check Blade output escaping | User-entered content is escaped by default | Pending |
| TC-092 | Security | Check password storage | Passwords are hashed in database | Pending |
| TC-093 | SEO URLs | Product slug URL works | `/products/{slug}` loads correct product | Pending |
| TC-094 | SEO URLs | News slug URL works | `/news/{slug}` loads correct news post | Pending |
| TC-095 | SEO URLs | Event slug URL works | `/events/{slug}` loads correct event | Pending |
| TC-096 | SEO Meta | Inspect page source | Title, description, canonical, Open Graph tags exist | Pending |
| TC-097 | Database Relationships | Product belongs to category | Product displays correct category | Pending |
| TC-098 | Database Relationships | Product has multiple images | Product detail shows additional images | Pending |
| TC-099 | Database Relationships | News belongs to user | Admin news record shows author relationship | Pending |
| TC-100 | Database Relationships | Event belongs to user | Admin event record shows author relationship | Pending |
| TC-101 | Database Relationships | Gallery belongs to category | Gallery image displays correct category | Pending |
| TC-102 | Database Relationships | Delete related records | Foreign key constraints behave as expected | Pending |

