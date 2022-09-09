<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
 xmlns:tools="http://schemas.android.com/tools"
 android:layout_width="match_parent"
 android:layout_height="match_parent"
 android:orientation="vertical"
 android:paddingBottom="@dimen/activity_vertical_margin"
 android:paddingLeft="@dimen/activity_horizontal_margin"
 android:paddingRight="@dimen/activity_horizontal_margin"
 android:paddingTop="@dimen/activity_vertical_margin"
 tools:context=".MainActivity">
 <Switch
 android:id="@+id/simpleSwitch1"
 android:layout_width="wrap_content"
 android:layout_height="wrap_content"
 android:layout_gravity="center"
 android:checked="false"
 android:text="switch 1"
 android:textOff="Off"
 android:textOn="On" />
 <Switch
 android:id="@+id/simpleSwitch2"
 android:layout_width="wrap_content"
 android:layout_height="wrap_content"
 android:layout_gravity="center"
 android:layout_marginTop="20dp"
 android:checked="true"
 android:text="switch 2"
 android:textOff="Off"
 android:textOn="On" />
 <Button
 android:id="@+id/submitButton"
 android:layout_width="wrap_content"