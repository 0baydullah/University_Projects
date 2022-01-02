/// A Real Life Problems Solution Using DP (Zero One KnapSack) ///
/// This code is written based on ### 0-1 Knapsack Algorithm ### ///

#include <bits/stdc++.h>
#include <iostream>
#include <windows.h>
#define endl "\n"
using namespace std;


///*******Functions Prototypes Starts*******///
void Loading_Screen();
int Second_Page();
int max(int a, int b);
bool cmp();
int ZOKS(int W, int wt[], int val[], int n);
int FKS(int W, int wt[], int val[], int n);
///*******Functions Prototypes Ends*******///


///*******Main Starts*******///
int main()
{

    Loading_Screen();
    system("COLOR F4");
    int key=Second_Page();


 /** Color Codes
    0 = Black       8 = Gray
    1 = Blue        9 = Light Blue
    2 = Green       A = Light Green
    3 = Aqua        B = Light Aqua
    4 = Red         C = Light Red
    5 = Purple      D = Light Purple
    6 = Yellow      E = Light Yellow
    7 = White       F = Bright White
*/

    cout << endl << endl;

    /**
    int val[] = { 60, 100, 120 };
    int wt[] = { 10, 20, 30 };
    int W = 50;
    */

    /**
    int val[] = {10, 40, 30, 50};
    int wt[] = { 5, 4, 6, 3};
    int W = 10;
    */

 //   /*
    int val[] = {132, 10 , 400 , 100 , 49 , 643 , 92};
    int wt[] = { 15, 40, 26, 63 , 88 , 40 , 30};
    int W = 250;
//    */


    int n = sizeof(val) / sizeof(val[0]); /// Storing Total Items Count


    cout << "\n\n\n\n  Total Items Count(s) is " << n << "\n\n\n";
    cout << "\tItems Weight & Value List :\n";
    cout << "\t__________________________\n\n";

    for(int i=0 ; i<n ; i++) /// Printing Weight & Value List
    {
        cout << "\t\t" << wt[i] << "\t" << val[i] << endl << endl;
    }

    cout << endl << endl << endl;

    int profit;

    if(key==1)
    {
        profit = FKS(W, wt, val, n);
    }
    else if(key == 2)
    {
        profit = ZOKS(W, wt, val, n);
    }




	cout << endl;
	cout << "  If You Take All Items of The list, Your Profit Will Be " << profit <<".....!!!\n\n\n";

	return 0;
}
///*******Main Ends*******///


///*******Functions Starts*******///
int max(int a, int b) /// Max Function (when stl is banned,then this function will return maximum value of two int)
{
    return (a > b) ? a : b;
}

bool comp(pair<int , int> p1 , pair<int , int> p2)
{
    double v1 = (double) p1.first/p1.second;
    double v2 = (double) p2.first/ p2.second;
    return v1>v2;
}

void Loading_Screen() /// Function For Loading Screen
{
    cout << endl << endl;
    cout << "\t\t\t####################################\n";
    cout << "\t\t\t##================================##\n";
    cout << "\t\t\t##=    IN SEARCH OF EL'DORADO    =##\n";
    cout << "\t\t\t##================================##\n"; /// printing Projects Title
    cout << "\t\t\t##================================##\n";
    cout << "\t\t\t##=    Maximize Your Profit!!    =##\n";
    cout << "\t\t\t##================================##\n";
    cout << "\t\t\t####################################\n\n\n\n\n\n\n";

    cout << "\t\t\t\tLOADING.......!!!\n\n\n";

    char x = 219;
    cout << "\t\t";
    for(int i=0; i<60; i++)
	{
	    system("color F4");
		cout << x;
		if(i<40)
		Sleep(50);
		else if(i<30)
		Sleep(40);
		else if(i>=10)
		Sleep(25);
		else
		Sleep(15);
	}
    system("cls");

}

int Second_Page()
{
    system("cls");
    cout << endl << endl;

    cout << "\t\t\t\t   Have You any Stone cutter With YOu???\n\n\n";
    cout << "\t\t\t##----------------------------------------------------------##\n";
    cout << "\t\t\t##----------------------------------------------------------##\n";
    cout << "\t\t\t##-    \t1.\tI Have Stone Cutter With Me!!              -##\n";
    cout << "\t\t\t##----------------------------------------------------------##\n"; /// printing Projects Title
    cout << "\t\t\t##----------------------------------------------------------##\n";
    cout << "\t\t\t##-    \t2.\tI Don't Have Any Stone Cutter With me!!    -##\n";
    cout << "\t\t\t##----------------------------------------------------------##\n";
    cout << "\t\t\t##----------------------------------------------------------##\n\n\n\n\n\n\n";



    int x;
    cout << "\t\t";
    cin >> x;
    if(x != 1 && x != 2)
    {
        Second_Page();
    }
    system("cls");
    return x;

}

int ZOKS(int W, int wt[], int val[], int n) /// 0-1 Knapsack Algorithm & Details of Taken Items Function
{
	int i, w;
	int K[n + 1][W + 1];

	for (i = 0; i <= n; i++) /// Build table K[][] in bottom up manner
    {
        for (w = 0; w <= W; w++)
        {
			if (i == 0 || w == 0)
            {
                K[i][w] = 0;
            }
			else if (wt[i - 1] <= w)
            {
                K[i][w] = max(val[i-1] + K[i-1][w-wt[i-1]], K[i-1][w]);
            }
			else
				K[i][w] = K[i - 1][w];
		}
	}

	int res = K[n][W];/// Storing result for finding Items
	int profit = res; /// Storing profit for returning profit to the main function

	w = W;

	cout << "  Optimum Profitable Items Detail list :\n" << endl << endl;
	cout << "\tSerial Number    \tWeight \t\t Profit\n";
    cout << "\t_______________________________________________\n\n";

	for (i = n; i > 0 && res > 0; i--)
        {
            if (res == K[i - 1][w]) /// Item NOT Taken
                continue;
            else /// This Item IS Taken
            {
                cout << "\t\t"<<i << "\t\t  "<<wt[i - 1] << "\t\t  " << val[i-1] << endl;
                cout << endl;
                res = res - val[i-1];
                w = w - wt[i-1];
            }
        }

	return profit; /// Returning profit To The Main Function
}

int FKS(int W, int wt[], int val[], int n) /// Fractional Knapsack algorithm & Details of Taken Items function
{
    vector <pair<int,int>> a(n);
    for(int i=0 ; i<n ; i++)
    {
        a[i].first = val[i];
        a[i].second = wt[i];
    }

    sort(a.begin(), a.end() , comp);

    int ans = 0 ;

    cout << "  Optimum Profitable Items Detail list :\n" << endl << endl;
	cout << "\tWeight    \tFree Space After Taking \t\t Profit\n";
    cout << "\t_______________________________________________________________\n\n";

    for(int i = 0 ; i<n ; i++)
    {
        if(W >= a[i].second)
        {

            ans += a[i].first;
            W -= a[i].second;
            cout << "\t" << a[i].second  <<"    \t\t\t" << W << "                               " << a[i].first << endl;
            continue;
        }
        double vW = (double) a[i].first/a[i].second;
        int x = W*vW;
        ans += vW*W;
        W = 0 ;
        cout << "\t" << a[i].second  <<"    \t\t\t"<< W << "                                  "  << x<< endl;
        break;

    }
    cout << endl;
    return ans;
}
///*******Functions Ends*******///

