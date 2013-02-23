/**********************************************************************************/
/*************************************SnEiK V1.0***********************************/
/**********************************************************************************/
/********************************************* author: Andrea Campodifiori*********/
/**********************************************************************************/

#include <SFML/Graphics.hpp>
#include <SFML/Window.hpp>
#include <iostream>
#include <sstream>
#include <vector>
#include "Collision.h"

//struct che contiene le coordinate di Circle
struct vector2d {
    int x, y;
    vector2d(int x, int y):x(x), y(y) {}
};

int main() {
    std::vector<vector2d> sneiklist;
    sf::RenderWindow App(sf::VideoMode(900, 640), "SnEiK");
    int X=310, Y=210; //coordinate iniziali di Circle
    int i=3, cnt=0, pnt=0;
    bool preso, scontro=false;
    sneiklist.push_back(vector2d(X,Y)); //inserisco le coordinate nel vector
    int X1=rand()%880+5, Y1=rand()%580+5; //coordinate casuali di Circle2
    float t=0.025; //tempo di pausa
    sf::Shape Circle=sf::Shape::Circle(X, Y, 15, sf::Color(192,255,62));
    sf::Shape Circle2=sf::Shape::Circle(X1, Y1, 10, sf::Color(255,0,0));
    sf::Shape Line=sf::Shape::Line(0, 600, 900, 600, 1, sf::Color(255,255,255));
    sf::Font MyFont;
    if (!MyFont.LoadFromFile("Ubuntu-B.ttf"))
        return EXIT_FAILURE;
    sf::Image Image;
    if (!Image.LoadFromFile("sf1.bmp"))
        return EXIT_FAILURE;
    sf::Sprite Sprite;
    Sprite.SetImage(Image);
    while(App.IsOpened()) {
        sf::Event Event;
        sf::String Text;
        std::string punt="Punteggio: ";
        Text.SetFont(MyFont);
        Text.SetSize(20);
        Text.Move(0, 610);
        while(App.GetEvent(Event)) {
            if(Event.Type==sf::Event::Closed)
                App.Close();
            if((Event.Type==sf::Event::KeyPressed)&&(Event.Key.Code==sf::Key::Escape))
                App.Close();
            if(i!=2&&(Event.Type==sf::Event::KeyPressed)&&(Event.Key.Code==sf::Key::Up))
                i=1;
            if(i!=1&&(Event.Type==sf::Event::KeyPressed)&&(Event.Key.Code==sf::Key::Down))
                i=2;
            if(i!=4&&(Event.Type==sf::Event::KeyPressed)&&(Event.Key.Code==sf::Key::Right))
                i=3;
            if(i!=3&&(Event.Type==sf::Event::KeyPressed)&&(Event.Key.Code==sf::Key::Left))
                i=4;
            }
        sf::Sleep(t);
        if(i==1) {
            std::ostringstream oss;
            std::string strcnt="";
            oss<<pnt;
            strcnt=oss.str();
            punt+=strcnt;
            Text.SetText(punt);
            if(Collision(X, X1, Y, Y1, 15, 5)){
                preso=true;
                pnt=pnt+(++cnt)+10;
                X1=rand()%880+5, Y1=rand()%590+5;
                Circle2=sf::Shape::Circle(X1,Y1,10, sf::Color(255,0,0));
            }
            int y1=Y;
            if(Y>15)
                Y-=15;
            else
                Y=585;
            sneiklist.push_back(vector2d(X, y1)); //inserisco le coordinate precedenti nel vector
            if(preso==false) {
                sneiklist.erase(sneiklist.begin()); //se non è stato preso il frutto, viene cancellato l'ultimo elemento
            }
            preso=false;
            App.Clear();
            App.Draw(Sprite);
            for(int i=0; i<sneiklist.size(); i++) {
                Circle=sf::Shape::Circle(sneiklist[i].x, sneiklist[i].y,15, sf::Color(i==(sneiklist.size()-1)?0:192,255,62));
                App.Draw(Circle);
        }
            App.Draw(Circle2);
            App.Draw(Line);
            App.Draw(Text);
            App.Display();
        }
        else if(i==2) {
            std::ostringstream oss;
            std::string strcnt="";
            oss<<pnt;
            strcnt=oss.str();
            punt+=strcnt;
            Text.SetText(punt);
            if(Collision(X, X1, Y, Y1, 15, 5)){
                preso=true;
                pnt=pnt+(++cnt)+10;
                X1=rand()%880+5, Y1=rand()%580+5;
                Circle2=sf::Shape::Circle(X1,Y1,10, sf::Color(255,0,0));
            }
            int y2=Y;
            if(Y<585)
                Y+=15;
            else
                Y=15;
            sneiklist.push_back(vector2d(X, y2));
            if(preso==false) {
                sneiklist.erase(sneiklist.begin());
            }
            preso=false;
            App.Clear();
            App.Draw(Sprite);
            for(int i=0; i<sneiklist.size(); i++) {
                Circle=sf::Shape::Circle(sneiklist[i].x, sneiklist[i].y,15, sf::Color(i==(sneiklist.size()-1)?0:192,255,62));
                App.Draw(Circle);
            }
            App.Draw(Circle2);
            App.Draw(Line);
            App.Draw(Text);
            App.Display();
        }
        else if(i==3) {
            std::ostringstream oss;
            std::string strcnt="";
            oss<<pnt;
            strcnt=oss.str();
            punt+=strcnt;
            Text.SetText(punt);
            if(Collision(X, X1, Y, Y1, 15, 5)){
                preso=true;
                pnt=pnt+(++cnt)+10;
                X1=rand()%880+5, Y1=rand()%580+5;
                Circle2=sf::Shape::Circle(X1,Y1,10, sf::Color(255,0,0));
            }
            int x1=X;
            if(X<885)
                X+=15;
            else
                X=15;
            sneiklist.push_back(vector2d(x1, Y));
            if(preso==false) {
                sneiklist.erase(sneiklist.begin());
            }
            preso=false;
            App.Clear();
            App.Draw(Sprite);
            for(int i=0; i<sneiklist.size(); i++) {
                Circle=sf::Shape::Circle(sneiklist[i].x, sneiklist[i].y,15, sf::Color(i==(sneiklist.size()-1)?0:192,255,62));
                App.Draw(Circle);
            }
            App.Draw(Circle2);
            App.Draw(Line);
            App.Draw(Text);
            App.Display();
        }
        else if(i==4) {
            std::ostringstream oss;
            std::string strcnt="";
            oss<<pnt;
            strcnt=oss.str();
            punt+=strcnt;
            Text.SetText(punt);
            if(Collision(X, X1, Y, Y1, 15, 5)){
                preso=true;
                pnt=pnt+(++cnt)+10;
                X1=rand()%880+5, Y1=rand()%580+5;
                Circle2=sf::Shape::Circle(X1,Y1,10, sf::Color(255,0,0));
            }
            int x2=X;
            if(X>15)
                X-=15;
            else
                X=885;
            sneiklist.push_back(vector2d(x2, Y));
            if(preso==false) {
                sneiklist.erase(sneiklist.begin());
            }
            preso=false;
            App.Clear();
            App.Draw(Sprite);
            for(int i=0; i<sneiklist.size(); i++) {
                Circle=sf::Shape::Circle(sneiklist[i].x, sneiklist[i].y,15, sf::Color(i==(sneiklist.size()-1)?0:192,255,62));
                App.Draw(Circle);
            }
            App.Draw(Circle2);
            App.Draw(Line);
            App.Draw(Text);
            App.Display();
        }

        for(int i=0; i<sneiklist.size()-1; i++) {
            if(Collision(X,sneiklist[i].x, Y, sneiklist[i].y, 7, 7))
                scontro=true;
        }
        if(scontro) {
            i=0;
            sleep(2);
            break;
        }
    }
    return EXIT_SUCCESS;
}
