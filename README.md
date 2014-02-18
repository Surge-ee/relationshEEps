relationshEEps
==============

ExpressionEngine plugin providing reverse search functionality for native relationship fieldtypes


Useage:

```
{exp:relationsheeps:herd flock="posts" related="authors" field="authors_name" value="Mark"}
	<p>Title: {title}</p>
	... you know the rest!
{/exp:relationsheeps:herd}
```
* Flock - The channel we are going to search in. (Parent Channel)
* Related - The channel we are relating to (Child Channel)
* Field - Field we are searching with
* Value - Value of the above field

The above snippet will find all posts by the author "Mark"
