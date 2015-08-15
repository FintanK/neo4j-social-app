<?php
namespace FintanK\Neo4JSocialApp\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class MainController
{
    /**
     * @param Application $application
     * @param Request $request
     * @return mixed
     */
    public function home(Application $application, Request $request)
    {
        $neo = $application['neo'];
        $q = 'MATCH (users:User) RETURN users';
        $result = $neo->sendCypherQuery($q)->getResult();

        if (is_null($result)) {
            $users = [];
        } else {
            $users = $result->get('users');
        }

        return $application['twig']->render('index.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @param Application $application
     * @param Request $request
     * @param $name
     * @return mixed
     */
    public function showUser(Application $application, Request $request, $name)
    {
        $neo = $application['neo'];
        $q = 'MATCH (user:User) WHERE user.name = {name}
         OPTIONAL MATCH (user)-[:FOLLOWS]->(f)
         OPTIONAL MATCH (f)-[:FOLLOWS]->(fof)
         WHERE NOT user.name = fof.name
         AND NOT (user)-[:FOLLOWS]->(fof)
         RETURN user, collect(distinct f) as followed, collect(distinct fof) as suggestions';
        $p = ['name' => $name];
        $result = $neo->sendCypherQuery($q, $p)->getResult();
        $user = $result->get('user');
        $followed = $result->get('followed');
        $suggestions = $result->get('suggestions');
        if (null === $user) {
            $application->abort(404, 'The user $name was not found');
        }
        return $application['twig']->render('user.html.twig', array(
            'user' => $user,
            'followed' => $followed,
            'suggestions' => $suggestions
        ));
    }

    /**
     * @param Application $application
     * @param Request $request
     * @return mixed
     */
    public function createRelationship(Application $application, Request $request)
    {
        $neo = $application['neo'];
        $user = $request->get('user');
        $toFollow = $request->get('to_follow');
        $q = 'MATCH (user:User {name: {name}}), (target:User {name:{target}})
        CREATE (user)-[:FOLLOWS]->(target)';
        $p = ['name' => $user, 'target' => $toFollow];
        $neo->sendCypherQuery($q, $p);
        $redirectRoute = $application['url_generator']->generate('show_user', array('name' => $user));
        return $application->redirect($redirectRoute);
    }

    /**
     * @param Application $application
     * @param Request $request
     * @return mixed
     */
    public function removeRelationship(Application $application, Request $request)
    {
        $neo = $application['neo'];
        $user = $request->get('name');
        $toRemove = $request->get('to_remove');
        $q = 'MATCH (user:User {name: {name}} ), (badfriend:User {name: {target}} )
        OPTIONAL MATCH (user)-[r:FOLLOWS]->(badfriend)
        DELETE r';
        $p = ['name' => $user, 'target' => $toRemove];
        $neo->sendCypherQuery($q, $p);
        $redirectRoute = $application['url_generator']->generate('show_user', array('name' => $user));
        return $application->redirect($redirectRoute);
    }
}